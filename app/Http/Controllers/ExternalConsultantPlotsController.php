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
        }

        $plots = Plot::with('certificates')->get();

//        return $plots;

        $ids = array();
        $cert_ids = array();

//        echo count($plots);
        foreach ($plots as $plot) {
//            echo $plot->certificates;
//            echo$cert_id = $plot->pivot->certificate_id;

//            for($i = 0; $i<= count($plot); $i++){

                foreach($plot->certificates as $plot_cert){

//                    echo "hi";

//                    echo( $plot_cert->pivot);

                    $plot_id = $plot_cert->pivot->plot_id;
                    $cert_id = $plot_cert->pivot->certificate_id;

                    $ids[] = $plot_id;
                    $cert_ids[] = $cert_id;
                }


//            echo $plot_certificate = $plot;
//            }

        }
//        return $cert_ids;

        $plots = $plots->whereIn('id', $ids)->all();

        foreach($plots as $certs){
            foreach($certs->certificates as $cert){
//                echo $cert->id;

            }
        }

//        foreach($plots as $plot){
//            echo $plot;
//        }
////
////        foreach ($plots as $plot){
////            echo "PLOT:: $plot";
////        }

//        return $cert_ids;
//        return $cert_id;
////
        return view('externalconsultant.plots.index', compact( 'plots', 'cert_ids'));
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
        //
//        return $request->all();

//        return $id;

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

//            $plot = Plot::find($id);
//
//            $plot->update(['build_status' => $status]);
        }else{
            return redirect('/externalconsultant/plots');
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
