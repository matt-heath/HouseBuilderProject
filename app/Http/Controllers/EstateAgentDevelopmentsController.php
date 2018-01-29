<?php

namespace App\Http\Controllers;

use App\Development;
use App\Plot;
use Illuminate\Http\Request;

use App\Http\Requests;

class EstateAgentDevelopmentsController extends Controller
{
    //
    public function index()
    {
        //
        $developments = Development::all();

        return view('/estateagent/developments/index', compact('developments'));
    }

    public function viewPlots($id){
        $plots = Plot::where('development_id', $id)->get();
        $development_name = Development::where('id', $id)->pluck('development_name')->first();

        return view('/estateagent/developments/viewplots', compact('plots', 'development_name'));
    }

}
