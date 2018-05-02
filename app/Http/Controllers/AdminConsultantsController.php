<?php

namespace App\Http\Controllers;

use App\CertificateCategory;
use App\CertificateRequired;
use App\Consultant;
use App\Development;
use App\Plot;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminConsultantsController extends Controller
{
    //

    public function index()
    {
        $certificatesCategory = CertificateCategory::where('name', 'Tradesmen certificates')->get()->pluck('id');
        $certificates = CertificateRequired::where('certificate_category_id', $certificatesCategory)->get();
        $consultants = User::where('role_id', '=', 5)->get()->pluck('consultant_details', 'id')->all();
        $developments = Development::pluck('development_name', 'id')->all();
        $roles = Role::where('id', '=', 5)->pluck('name', 'id')->first();

        return view('admin.consultants.index', compact( 'certificates', 'consultants', 'developments', 'roles'));
    }

    public function store()
    {
        return 'STORE VALUES';
    }

    public function findPhases(Request $request){

//        return $request->id;

//        $phases = Plot::where('house_type', $request->id)->pluck('phase')->distinct()->all();

//         $phases = Plot::where('house_type', $request->id)->distinct()->orderBy('phase', 'asc')->get(['phase']);
        $phases = Phases::where('development_id', $request->id)->get();

        return response()->json($phases);

    }

    public function findPlots(Request $request){

        $plots = Plot::where('phase', $request->id)->where('development_id', $request->dev_id)->get();
        return response()->json($plots);
    }

    public function getHouseTypes(Request $request){
        $data = Plot::where('development_id', $request->id)->get();
        return response()->json($data);
    }
}
