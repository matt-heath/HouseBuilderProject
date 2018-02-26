<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\CertificateCategory;
use App\CertificateRejection;
use App\Consultant;
use App\Plot;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminCertificatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $certificates = Certificate::all();


        return view('admin.certificates.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $certificates = CertificateCategory::pluck('name', 'id')->all();
//        $certificates = CertificateCategory::all();
        return view('admin.certificates.create', compact('certificates'));
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
//        return $request->all();
//        $certificatesModel = new Certificate();

        //Get all form submitted data.
        $input = $request->all();

        //Declare arrays to be used.
        $items = array();
        $ids = array();
        $plot_arr = array();

        //Search for plots where the name ID is less than/equal to the num of plots selected and where housetype is the same as form submitted one.
        $plots = Plot::where('plot_name_id', '<=', $request->selected_plots)->where('house_type', $request->house_type)->get();

        //Loop to create multiple certificateModels and assign items to an item array.
        for($i = 1; $i <= $request->selected_plots; $i++) {

            $certificatesModel[$i] = new Certificate();

            $item = array(
                'certificate_name' => '',
                'certificate_check' => 'False',
                'certificate_doc' => '',
                'certificate_category_id' => $input['certificate_category_id']
            );

            $certificatesModel[$i]->fill($item);
            $items[] = $item;

            //save certificate model item to Certificates table
            $certificatesModel[$i]->save($item);


            if ($request) {
                $consultant = Consultant::find($request->consultant_id);
                $consultant->certificates()->attach($certificatesModel[$i]->id);
            }

            foreach ($plots as $plot){
                $plot_certificates = $plot->certificates();
                $certificatesModel[$i]->id;
                $plot_id = $plot->id;
                $plot_arr[] = $plot_id;
            }

            $ids[] = $certificatesModel[$i]->id;
        }
//        return $ids


        for($z = 0; $z < count($ids); $z++){

           echo $plot_id = $plot_arr[$z];

//            var_dump( $plot_id);

            $plot_certificates->attach($ids[$z], ['plot_id'=> $plot_id]);
        }

        return redirect('/admin/certificates');
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

        $plots = Plot::with('certificates')->where('id', $id)->get();

        foreach($plots as $plot){
            $certificates = $plot->certificates;
        }

//        echo $certificates;

        return view('admin.certificates.edit', compact('plots', 'certificates'));
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
//        return $id;
//        return $request->all();

        $certificate_check = $request->certificate_check;
        $status = $request->status;

        if($status === 'yes'){
            $status = 'Ready for inspection';
            $certificate = Certificate::findOrFail($id);

            $certificate->build_status = $status;
            $certificate->save();

//            $certificate->update(['build_status' => $status]);

//            return 'DONE';
        }else if(isset($certificate_check)){
//            return "hi";
//            return $request->all();
            $certificate = Certificate::findOrFail($id);

            if($certificate_check == 1){
                $certificate->certificate_check = $certificate_check;
                $certificate->build_status = 'Accepted';
                $certificate->save();
                return redirect()->back();
            }else if ($certificate_check == 0){
                $certificate->certificate_check = $certificate_check;
                $certificate->build_status = 'Awaiting approval';
                $certificate->save();

                return redirect()->back();
            }else if($certificate_check == 3){
                $certificate->certificate_check = 1;
                $certificate->build_status = 'Rejected';
                $certificate->save();


                $input = [
                    'certificate_id' => $id,
                    'rejection_reason' => $request->rejection_reason
                ];
                CertificateRejection::create($input);
            }

//            return 'NOT DONE';
        }else{
            return redirect()->back();
        }

        return redirect()->back();
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
//        Certificate::findOrFail($id);
//
//        $consultant = Consultant::all();
//
//        $consultant->certificates()->detach($consultant['id']);
    }

    public function getRejectionReasons(Request $request){
//        return $request->id;
        $certificate = CertificateRejection::where('certificate_id', $request->id)->get();

        return response()->json($certificate);
    }
}
