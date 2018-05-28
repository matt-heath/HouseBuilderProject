<?php

namespace App\Http\Controllers;

use App\Development;
use App\EstateAgent;
use App\HouseType;
use App\Phases;
use App\Plot;
use App\Supplier;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class EstateAgentDevelopmentsController extends Controller
{
    //
    public function index()
    {
        //
        $userId = Auth::id();
//        with('certificates')->where('user_id', $user_id)->first()
        $estateAgent = EstateAgent::where('user_id', $userId)->first();

        $developments = $estateAgent->developments()->get();

        $ids = array();

        foreach ($developments as $development){
            $id = $development['id'];

            $ids[] = $id;
        }

        $num_of_plots_available = Plot::whereIn('development_id', $ids)->get();

        return view('/estateagent/developments/index', compact('developments', 'num_of_plots_available'));
    }

    public function show($id)
    {
        $development = Development::with('suppliers')->where('id', $id)->first();
        $plots = Plot::where('development_id', $id)->get();
        $num_of_plots_available = Plot::where('development_id', $id)->get();
        $houseTypes = HouseType::where('development_id', $id)->get();
        $suppliers = User::where('role_id', '=', 3)->get()->pluck('supplier_details', 'id')->all();
//        $supplierDetails = Supplier::with('developments')->get()

        $supplierDetails = Supplier::whereHas('developments', function ($query) use ($id) {
            $query->where('development_id', $id);
        })->get();
        $default = $development->suppliers()->pluck('supplier_company_name','id');
        $estate_agent = $development->estateAgent()->first();

        $phaseDetails = Phases::where('development_id', $id)->get();

        $items = array();
        $assigned = array();

        foreach($development->suppliers as $supplier) {
            $details = $supplier->selectionCategory->toArray();
            $items[] = $details;
        }

        for($i = 0; $i < count($items); $i++){
            $assigned[] = $items[$i];
        }

        return view('estateagent.developments.show', compact('plots', 'development', 'num_of_plots_available', 'houseTypes', 'suppliers', 'default', 'assigned', 'estate_agent', 'phaseDetails', 'supplierDetails'));
    }

    public function viewPlots($id){
        $plots = Plot::where('development_id', $id)->get();
        $development_name = Development::where('id', $id)->pluck('development_name')->first();

        return view('/estateagent/developments/viewplots', compact('plots', 'development_name'));
    }

}
