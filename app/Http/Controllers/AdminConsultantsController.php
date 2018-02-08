<?php

namespace App\Http\Controllers;

use App\CertificateCategory;
use App\Consultant;
use App\Development;
use App\Plot;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminConsultantsController extends Controller
{
    //

    public function index()
    {
        $certificates = CertificateCategory::lists('name', 'id')->all();
        $consultants = Consultant::all();
        $developments = Development::lists('development_name', 'id')->all();


        $options = [];

        foreach ($consultants as $consultant){
            $options[$consultant->id] = $consultant->user->name;
        }

        return view('admin.consultants.index', compact( 'certificates', 'options', 'developments'));

    }

    public function store()
    {
        return 'STORE VALUES';
    }

    public function findPhases(Request $request){

//        return $request->id;

//        $phases = Plot::where('house_type', $request->id)->lists('phase')->distinct()->all();

        return $phases = Plot::where('house_type', $request->id)->distinct()->orderBy('phase', 'asc')->get(['phase']);
        return response()->json($phases);

    }

    public function findPlots(Request $request){

        $plots = Plot::where('phase', $request->id)->get();
        return response()->json($plots);

    }
}
