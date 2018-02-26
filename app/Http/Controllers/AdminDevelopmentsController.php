<?php

namespace App\Http\Controllers;

use App\Development;
use App\HouseType;
use App\Http\Requests\DevelopmentsCreateRequest;
use App\Photo;
use App\Plot;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminDevelopmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $developments = Development::all();

        $ids = array();

        foreach ($developments as $development){
            $id = $development['id'];

            $ids[] = $id;
        }

//        $ids[] = $id;

        $num_of_plots_available = Plot::whereIn('development_id', $ids)->get();

//        return ($num_of_plots_available);

        return view('admin.developments.index', compact('developments', 'num_of_plots_available'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.developments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        dd( $request->input() );
//        return $request->all();
        $input = $request->all();

//        dd($input);
//        $houseTypesArray = $request->input('house_type_name');


//        return $houseTypesArray;

//        return $input;

//        $items = array();
//
//        for ($i = 0; $i < count($houseTypesArray); $i++){
//            echo "hi";
//
//            $item = array(
//                'house_type_name' => $request->house_type_name[$i],
//                'house_type_desc' => $request->house_type_desc[$i],
////                'floor_plan' => $request->photo_id[$i],
////                'house_img' => $request->house_img[$i]
//            );
//
//            $items[] = $item;
//
//        }

//        echo count($items);

//        HouseType::insert($items);
//
//
        if($file = $request->file('photo_id')){

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=> $name]);

            $input['photo_id'] = $photo->id;

        }

        Development::create($input);

        return redirect('/admin/developments');
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
        return view('admin.developments.show');
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

        $development = Development::findOrFail($id);

        return view('admin.developments.edit', compact('development'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DevelopmentsCreateRequest $request, $id)
    {
        //

        $input = $request->all();
        $development = Development::findOrFail($id);

        if($file = $request->file('photo_id')){

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=> $name]);

            $input['photo_id'] = $photo->id;

        }

//        dd(Auth::user()->developments()->whereId($id)->first()->update($input);

        $development->update($input);

        return redirect('/admin/developments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $development = Development::findOrFail($id); // find user and delete.

        if($development->photo_id){
            unlink(public_path() . $development->photo->file);
        }

        $development->delete();

        Session::flash('deleted_development', 'The development has been deleted');

        return redirect('/admin/developments'); // upon deletion, redirect to users table.

    }


    public function development($id) {
        $development = Development::findOrFail($id);

         $plots = Plot::where('development_id', $id)->get();
//         $plots->where('development_id', '=', $id);


        return view('development', compact('development', 'plots'));
    }
}
