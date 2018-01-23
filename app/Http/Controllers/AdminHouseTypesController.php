<?php

namespace App\Http\Controllers;

use App\Development;
use App\HouseType;
use App\Photo;
use App\Plot;
use Illuminate\Http\Request;

use App\Http\Requests;

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
        $plots = Plot::lists('development_id', 'id')->all();

        return view('admin.housetypes.index', compact('houseTypes', 'plots'));


//        $developments = Development::lists('development_name', 'id')->all();
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
        $developments = Development::lists('development_name', 'id')->all();
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
        //

        $input = $request->all();

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


        return redirect('/admin/housetypes');
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
        $developments = Development::lists('development_name', 'id')->all();

        return view('admin.housetypes.edit', compact('houseTypes', 'developments'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $houseTypes = HouseType::findOrFail($id);
        $houseTypes->update($request->all());

        return redirect('/admin/housetypes');


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

        HouseType::findOrFail($id)->delete();

        return redirect('/admin/housetypes');
    }
}
