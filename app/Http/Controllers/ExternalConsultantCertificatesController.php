<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\CertificateCategory;
use App\Plot;
use Illuminate\Http\Request;

use App\Http\Requests;

class ExternalConsultantCertificatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('externalconsultant.certificates.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('externalconsultant.certificates.create');

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

//        return $id;

        $certificate = Certificate::where('id', $id)->first();
        $category = CertificateCategory::where('id', $certificate->certificate_category_id )->lists('name', 'id')->all();

//        return $plots;

        return view('externalconsultant.certificates.edit', compact('certificate', 'category', 'id'));
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
        $input = $request->all();

//        return $id;

        $certificate = Certificate::findOrFail($id);

        if($file = $request->file('certificate_doc')) {

            $status = 'Awaiting approval';

//            return $certificate;

            $name = time(). $file->getClientOriginalName();
            $file->move('documents', $name);
            $certificate->update(['certificate_doc'=> $name]);

            $certificate->build_status = $status;
            $certificate->save();
        }


//        TODO:: Change build status/document to 'Awaiting approval'

        $plots = Plot::with('certificates')->get();


//        $ids = array();
//        foreach ($plots as $plot) {
//
////            echo $plot;
//
//            foreach($plot->certificates as $plot_cert){
//               $pivot_val =  $plot_cert->pivot;
//
////               $pivot_val = $pivot_val->plot_id->w
////                echo $pivot_val;
//
//
//                if($pivot_val->where('certificate_id',$id)) {
////                    dd('test');
//
////                    return $pivot_val;
//
//                    $plot_id = $pivot_val->where('certificate_id', $id)->pluck('plot_id')->first();
//                    return $plot = Plot::where('id', $plot_id)->first()->update('Awaiting certificate');
//                }
////                if($pivot_val->contains('certificate_id', $id)){
////                    dd('test');
////                }
//
////               $ids[] = $pivot_val;
//            }
//
//
//
//        }


//        return $ids->plot_id->where('certificate_id', $id);


        return redirect('/externalconsultant/certificates');

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
}
