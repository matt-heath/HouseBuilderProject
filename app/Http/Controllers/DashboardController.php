<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Development;
use App\HouseType;
use App\Plot;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function admin(){

        $developments = Development::all()->count();
        $plots = Plot::all()->count();
        $houseTypes = HouseType::all()->count();
        $certificates = Certificate::where('certificate_check', '=', '0')->where('build_status', '=', 'Awaiting approval')->get()->count();

        return view('admin.index', compact('developments', 'plots', 'houseTypes', 'certificates'));
    }
}
