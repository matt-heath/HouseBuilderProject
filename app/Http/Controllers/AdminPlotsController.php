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
        $plots = Plot::all();
//        $developments = Development::lists('development_name', 'id')->all();
//        $houseTypes = HouseType::lists('house_type_name', 'id')->all();

        return view('admin.plots.index', compact('plots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $plots = Plot::all();
        $developments = Development::lists('development_name', 'id')->all();
        $houseTypes = HouseType::lists('house_type_name', 'id')->all();
        return view('admin.plots.create', compact('plots', 'developments', 'houseTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all = $request->all();

        $plotsArray = $request->plot_name;
        $sqftArray = $request->input('sqft');
        $statusArray = $request->input('status');

        $items = array();


        for($i = 0; $i < count($plotsArray); $i++){
            $item = array(
                'development_id' => $all['development_id'],
                'plot_name' => $plotsArray[$i],
                'house_type'=> $all['house_type'],
                'sqft' => $sqftArray[$i],
                'phase' => $all['phase'],
                'status' => $statusArray[$i]
            );

            $items[] = $item;
        }


        Plot::insert($items);

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
        $houseType = HouseType::lists('house_type_name', 'id','house_img')->all();

        return view('admin.plots.edit', compact('plot', 'developments', 'houseType'));
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
