<?php

namespace App\Http\Controllers;

use App\HouseType;
use App\Photo;
use App\SelectionCategory;
use App\SelectionType;
use App\Supplier;
use App\User;
use App\Variation;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;

class VariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    public function createVariation($id)
    {
//        return $id;

        $supplier = Supplier::where('id', $id)->first();
        $categories = SelectionCategory::with('selectionType')->where('id', $supplier->supplier_type)->first();
//        return $categories;
//        $category_id = $categories->id;

        $selectionTypes = $categories->selectionType->pluck('type_name', 'id');

//        return $selectionTypes;


        $categories = $categories->pluck('category_name', 'id');

        return view('admin.variations.create', compact('supplier', 'selectionTypes', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();
        $variationModel = new Variation();
        $supplier_id = $input['supplier_id'];
        $type_id = $input['selection_type_id'];

        if ($file = $request->file('extra_img')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $input['extra_img'] = $photo->id;
        }

        $variationModel->fill($input)->save();
//        Variation::create($input);

        $id = $variationModel->id;

        $variation = Variation::where('supplier_id', $supplier_id)->where('id', $id)->first();
        $variation->selectionType()->attach($variationModel->id, ['selection_type_id' => $type_id]);

//        $plot_certificates->attach($ids[$y], ['plot_id' => $plot_id]);


//        return "CREATED"
        Alert::success('Supplier variation added to the system!')->flash();

        return redirect('/admin/suppliers/' . $supplier_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Variation $variation
     * @return \Illuminate\Http\Response
     */
    public function show(Variation $variation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Variation $variation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
//        return $id;

        $variation = Variation::with('selectionType')->where('id', $id)->first();

//        TODO: May need changed to selectionType() like suppliercontroller
        $default = $variation->selectionType->first();
        $supplier = Supplier::where('id', $variation->supplier_id)->first();
        $categories = SelectionCategory::with('selectionType')->where('id', $supplier->supplier_type)->first();
        $selectionTypes = $categories->selectionType->where('type_name', '!==', $default->type_name)->pluck('type_name', 'id');

//        return $selectionTypes;

        $default = $variation->selectionType()->pluck('type_name')->first();

        $categories = $categories->where('id', $supplier->supplier_type)->orderByRaw("FIELD(category_name, '$default') ASC")->pluck('category_name', 'id');


//        return $categories->selectionType()->orderBy('selection_type_id', 'asc')->get();


        return view('admin.variations.edit', compact('variation', 'categories', 'selectionTypes', 'default'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Variation $variation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $variation = Variation::findOrFail($id);

        if ($file = $request->file('extra_img')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $input['extra_img'] = $photo->id;
        }
        $variation->update($input);
        Alert::success('Variation details successfully updated!')->flash();

        return redirect('/admin/suppliers/' . $variation->supplier_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Variation $variation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $variation_del = Variation::find($id);
        if ($variation_del->extra_img) {
            unlink(public_path() . $variation_del->photo->file);
        }
        $variation_del->delete();
        Alert::info('Variation removed from the system.')->flash();

        return redirect()->back();
    }

    public function assignToHouseType(Request $request)
    {
//        return $request->all();
        $input = $request->all();
        if (isset($input['variations'])) {
            $num_of_variations = count($input['variations']);
            $variations = $input['variations'];
        }
        $house_type_id = $input['house_type_id'];
        $houseType = HouseType::where('id', $house_type_id)->first();
//
//        return $variation_ids;
        $variation_ids = $houseType->variations()->get();
        $items = array();
        foreach ($variation_ids as $variation_id) {
            $item = [
                $variation_id->pivot->variation_id
            ];
            $items[] = $item;
        }
//        return $items;

        if (isset($input['variations'])) {
            for ($count = 0; $count < $num_of_variations; $count++) {
                $answer = $houseType->variations()->where('variation_id', $variations[$count])->exists();

                if (!$answer) {
                    $houseType->variations()->attach($variations[$count]);
                }
//                echo $variations[$count];
                foreach ($items as $item) {
//                    dd($item[0]);
                    if (!in_array($item[0], $variations)) {
//                        echo "No, item: $item[0] doesn't exits in array";
                        $houseType->variations()->detach($item[0]);

                    }
                }
            }
        }else {
            foreach ($items as $item) {
                $houseType->variations()->detach($item);
            }
        }
//        return null;
//        return null;

        Alert::success('House type variations updated!')->flash();


        return redirect('/admin/housetypes/' . $house_type_id);
    }
}
