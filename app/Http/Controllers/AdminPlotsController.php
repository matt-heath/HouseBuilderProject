<?php

namespace App\Http\Controllers;

use App\Development;
use App\HouseType;
use App\Plot;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminPlotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $plots = Plot::all();
        $developments = Development::lists('development_name', 'id')->all();
        $houseTypes = HouseType::lists('house_type_name', 'id')->all();

        return view('admin.plots.index', compact('plots', 'developments', 'houseTypes'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        Plot::create($request->all());

        return redirect('/admin/plots');
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

        $plot = Plot::findOrFail($id);
        $developments = Development::lists('development_name', 'id')->all();

        return view('admin.plots.edit', compact('plot', 'developments'));
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

        $plot = Plot::findOrFail($id);

        $plot->update($request->all());

        return redirect('/admin/plots');

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
        Plot::findOrFail($id)->delete();


        return redirect('/admin/plots');
    }
}
