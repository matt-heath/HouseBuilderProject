<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Development;
use App\HouseType;
use App\Http\Requests\PlotsRequest;
use App\Phases;
use App\Plot;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prologue\Alerts\Facades\Alert;

class AdminPlotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get plots with a pivot relation certificates and return to plots index view
        $plots = Plot::with('certificates')->get();


        return view('admin.plots.index', compact('plots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plots = Plot::all();
        $developments = Development::pluck('development_name', 'id')->all();
        $houseTypes = HouseType::pluck('house_type_name', 'id')->all();
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
        Plot::insert($items);
        Alert::success('Plot(s) added to the development!')->flash();

        return redirect('/admin/developments/'.$all['development_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plot = Plot::where('id', $id)->first();
        $image = HouseType::where('id', $plot->house_type)->first();
        $certificates = $plot->certificates;
        return view('admin.plots.show', compact('plot', 'image', 'certificates'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plot = Plot::findOrFail($id);
        $developments = Development::pluck('development_name', 'id')->all();
        $houseType = HouseType::pluck('house_type_name', 'id')->all();
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
    public function update(Request $request, $id)
    {
        $plot = Plot::where('id', $id)->first();
        $dev_id = $plot->development_id;
        $plot->update($request->all());
        Alert::success('Plot successfully updated!')->flash();

        return redirect('/admin/developments/'.$dev_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plot = Plot::findOrFail($id);
        Alert::info('Plot successfully deleted.')->flash();
        $plot->delete();
        return redirect('/admin/developments/'.$plot->development_id);
    }


    public function plotsByDevelopment($id) {
        $development = Development::findOrFail($id);
        $plots = Plot::where('development_id', $id)->get();
//         $plots->where('development_id', '=', $id);
        return view('/admin/plots/plotsbydevelopment', compact('development', 'plots'));
    }

    public function findNumPlots(Request $request){
        $num_of_plots_available = Plot::where('development_id', $request->id)->where('phase', $request->phase_id)->get();

        $count = $num_of_plots_available->count();

        $totalPlots = Phases::where('id', $request->phase_id)->get()->pluck('num_plots')->first();
//        $totalPlots = Development::where('id', $request->id)->get()->pluck('development_num_plots')->first();

        $plots_left =($totalPlots - $count);
//        $plots_left = $totalPlots->diff($count);

        if($plots_left == $totalPlots){
            $plots_left = $totalPlots;
        }
        $arr['plots_left'] = $plots_left;
        return response()->json($plots_left);
    }

    public function findHouseTypes(Request $request) {
//        return $request->id;

//        $arr = array();
        $data = HouseType::where('development_id', $request->id)->get();
//        $arr[] = $data;
//
//        $num_of_plots_available = Plot::where('development_id', $request->id)->get();
//
//        $count = $num_of_plots_available->count();
//
//        $totalPlots = Development::where('id', $request->id)->get()->pluck('development_num_plots')->first();
//
//        $plots_left =($totalPlots - $count);
////        $plots_left = $totalPlots->diff($count);
//
//        if($plots_left == $totalPlots){
//            $plots_left = $totalPlots;
//        }
//        $arr['plots_left'] = $plots_left;

//        $arr = json_encode(array("a" => $data, "b" => $plots_left));

        return response()->json($data);
    }

    public function developmentPhases(Request $request) {
        $phases = Phases::where('development_id', $request->id)->get();
//        return $phases;
        return response()->json($phases);
    }
}
