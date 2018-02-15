<?php

namespace App\Http\Controllers;

use App\Development;
use App\HouseType;
use App\Http\Requests\PlotsRequest;
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
//        $plots = Plot::all();

        $plots = Plot::with('certificates')->get();
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
//        $phases = Development::pluck('phase');
        $houseTypes = HouseType::lists('house_type_name', 'id')->all();
        return view('admin.plots.create', compact('plots', 'developments', 'houseTypes', 'phases'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlotsRequest $request)
    {
        $all = $request->all();

//        return $all['phase'];

        $houseType = HouseType::where('id', $all['house_type'])->pluck('house_type_name')->first();

        $plots = Plot::where('house_type', $all['house_type'])->pluck('plot_name_id')->last();

        if($plots){
            $plotsArray = $request->num_of_plots + $plots;
            $plots = $plots + 1;
        }else{
            $plotsArray = $request->num_of_plots;
            $plots = 1;
        }

        $houseType = str_replace(' ', '_', $houseType);
//        $sqftArray = $request->input('sqft');
//        $statusArray = $request->input('status');

        $items = array();

        for($i = $plots; $i <= $plotsArray; $i++){
            $item = array(
                'development_id' => $all['development_id'],
                'plot_name'      => 'Braidwater_'.$houseType.'_'.$i,
                'house_type'     => $all['house_type'],
                'sqft'           => $all['sqft'],
                'status'         => $all['status'],
                'phase'          => $all['phase'],
                'plot_name_id'   => $i
            );
            $items[] = $item;
        }
//        var_dump( $items);

//
        Plot::insert($items);
//
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
        $houseType = HouseType::lists('house_type_name', 'id')->all();

        $image = HouseType::where('id', $plot->house_type)->first();

        return view('admin.plots.edit', compact('plot', 'developments', 'houseType','image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlotsRequest $request, $id)
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


    public function plotsByDevelopment($id) {
        $development = Development::findOrFail($id);

        $plots = Plot::where('development_id', $id)->get();
//         $plots->where('development_id', '=', $id);

        return view('/admin/plots/plotsbydevelopment', compact('development', 'plots'));
    }

    public function findHouseTypes(Request $request) {
//        return $request->id;

        $data = HouseType::where('development_id', $request->id)->get();
        return response()->json($data);
    }

    public function developmentPhases(Request $request) {
        $phases = Development::where('id', $request->id)->pluck('phase')->all();
        return response()->json($phases);
    }
}
