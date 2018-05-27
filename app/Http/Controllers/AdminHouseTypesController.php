<?php

namespace App\Http\Controllers;

use App\Development;
use App\HouseType;
use App\Http\Requests\HouseTypesRequest;
use App\Photo;
use App\Plot;
use App\SelectionCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prologue\Alerts\Facades\Alert;

class AdminHouseTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $houseTypes = HouseType::all();
        $plots = Plot::pluck('development_id', 'id')->all();

        return view('admin.housetypes.index', compact('houseTypes', 'plots'));


//        $developments = Development::pluck('development_name', 'id')->all();
//
//        return view('admin.plots.index', compact('plots', 'developments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $developments = Development::pluck('development_name', 'id')->all();
        return view('admin.housetypes.create', compact('developments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $development_id = $input['development_id'];
        if($file = $request->file('floor_plan')){
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file'=> $name]);
            $input['floor_plan'] = $photo->id;
        }
        if($file_house_img = $request->file('house_img')){
            $name = time() . $file_house_img->getClientOriginalName();
            $file_house_img->move('images', $name);
            $photo = Photo::create(['file'=> $name]);
            $input['house_img'] = $photo->id;
        }
        HouseType::create($input);
        Alert::success('House Type added to the system!')->flash();

        return redirect('/admin/developments/'.$development_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $houseType = HouseType::where('id', $id)->first();
        $supplier_categories = SelectionCategory::all();
        $development = Development::where('id', $houseType->development_id)->first();
        $assignedSuppliers = $development->suppliers()->get();

        $variation_ids = $houseType->variations()->get();

        $items = array();
        foreach ($variation_ids as $variation_id){
            $item = $variation_id->pivot->variation_id;
            $items[] = $item;
        }
//        return $items;
//        return null;

        return view('admin.housetypes.show', compact('houseType', 'supplier_categories', 'assignedSuppliers', 'variation_ids','items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $houseTypes = HouseType::findOrFail($id);
        $developments = Development::where('id', $houseTypes->development_id)->pluck('development_name', 'id')->all();

        return view('admin.housetypes.edit', compact('houseTypes', 'developments'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HouseTypesRequest $request, $id)
    {
        $input = $request->all();

        if($input['house_type_name']){
            $houseTypeName = $input['house_type_name'];
            $plots = Plot::where('house_type', $id)->get();
            $plot_count = $plots->count();
            $houseTypeName = str_replace(' ', '_', $houseTypeName);
            $houseNum = 1;
            for($i = 0; $i < $plot_count; $i++){
                $plots[$i]->update(['plot_name' => 'Braidwater_'.$houseTypeName.'_'.$houseNum]);
                $houseNum++;
            }
        }
        $houseTypes = HouseType::findOrFail($id);

        if($file = $request->file('floor_plan')){
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file'=> $name]);
            $input['floor_plan'] = $photo->id;
        }
        if($file_house_img = $request->file('house_img')) {
            $name = time() . $file_house_img->getClientOriginalName();
            $file_house_img->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $input['house_img'] = $photo->id;
        }
        $houseTypes->update($input);
        Alert::success('House Type successfully updated!')->flash();

        return redirect('/admin/developments/'.$input['development_id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $houseType = HouseType::findOrFail($id);
        $houseType->delete();
        Plot::where('house_type', $id)->delete();
        Alert::info('House Type deleted from the system.')->flash();

        return redirect('/admin/developments/'.$houseType->development_id);
    }
}
