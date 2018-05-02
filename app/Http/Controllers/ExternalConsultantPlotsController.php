<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Consultant;
use App\Plot;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ExternalConsultantPlotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $status = array();
        $certificate_ids = array();

//        return $certificate = Certificate::with('consultants')->first();

        //get current user ID
        $user_id =  Auth::id();

        $consultants = Consultant::with('certificates')->where('user_id', $user_id)->first();


//        return $consultants->pluck('id')

//        $consultant->certificates()->attach($certificatesModel->id);

        foreach ($consultants->certificates as $consultant){
//            echo "Certificate: $consultant->certificate_name, pivot value: $consultant->pivot";

//            echo $consultant;
            $certificate_id = $consultant->pivot->certificate_id;

            $certificate_ids[] = $certificate_id;
        }

//        return $certificate_ids;



        $plots = Plot::whereHas('certificates', function ($query) use ($certificate_ids){
            $query->whereIn('certificate_id', $certificate_ids);
        })->get();

//
//        return $cert_ids;
//
//        $plots = $plots->whereIn('id', $ids)->all();
//
//        foreach($plots as $certs){
//            foreach($certs->certificates as $cert){
////                echo $cert->id;
//
//            }
//        }

        foreach($plots as $plot){
//            echo $plot;

            foreach($plot->certificates as $certificate) {
                if (in_array($certificate->id, $certificate_ids)) {
                    $status[] = $certificate->build_status;
                }
            }
        }
////
//        return $status;
////        foreach ($plots as $plot){
////            echo "PLOT:: $plot";
////        }
//        return $plots;
//        return $certificate_ids;
//        return $cert_id;
////
        return view('externalconsultant.plots.index', compact( 'plots', 'certificate_ids', 'status'));
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
        $plots = Plot::with('certificates')->where('id', $id)->get();
        $status = $request->status;

        if($status === 'yes'){
            $status = 'Property being inspected';
            foreach($plots as $plot){
                foreach($plot->certificates as $certificate){
                    $certificate = $certificate->where('build_status', 'Ready for inspection')->get();
                }
            }
            for($i = 0; $i < count($certificate); $i++){
                $certificate[$i]->build_status = $status;
                $certificate[$i]->save();
            }
        }else{
            return redirect()->back();
        }
        return redirect('/externalconsultant/plots');
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
    }

    public function updateBuildStatus($id){
        return "hi";
    }
}
