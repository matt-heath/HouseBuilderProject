<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\CertificateCategory;
use App\CertificateRejection;
use App\CertificateRequired;
use App\Consultant;
use App\Phases;
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
        $last_id = "";

        $phase = Phases::where('id', $request->phase)->first();

        $num_of_plots = $phase->num_plots;
//        return $category_id = $input['certificate_category_id'];

        //Search for plots where the name ID is less than/equal to the num of plots selected and where housetype is the same as form submitted one.
        $plots = Plot::where('development_id', $request->development_id)->where('plot_name_id', '<=', $phase->num_plots)->where('phase', $request->phase)->get();


        $certificatesRequired = CertificateRequired::all();
        $consultant_id = $input['consultant_id'];
        $cert_name = $input['certificate_name'];

//        echo count($cert_name);

        for ($z = 0; $z < count($cert_name); $z++) {
            $certificates = CertificateRequired::where('id', '=', $cert_name[$z])->get();
//            echo $certificates;

            foreach ($certificates as $certificate) {
//                echo "<h1>" . $consultant_id[$z] . "</h1>";
                for ($count = 0; $count < $num_of_plots; $count++) {
                    $certificatesModel[$count] = new Certificate();

                    foreach ($plots as $plot) {
                        $plot_certificates = $plot->certificates();
//                $certificatesModel[$i]->id;
                        $plot_id = $plot->id;
                        $plot_arr[] = $plot_id;
                    }

                    $item = array(
                        'certificate_check' => 'False',
                        'certificate_doc' => '',
                        'certificates_required_id' => $cert_name[$z]
                    );

                    $certificatesModel[$count]->fill($item)->save();
                    $items[] = $item;

                    $ids[] = $certificatesModel[$count]->id;
                    $consultant = Consultant::where('user_id', $consultant_id[$z])->first();
                    $consultant->certificates()->attach($certificatesModel[$count]->id);
                }

            }
        }
        for ($y = 0; $y < count($ids); $y++) {
            $plot_id = $plot_arr[$y];
            $plot_certificates->attach($ids[$y], ['plot_id' => $plot_id]);
        }

//        return null;

        //Loop to create multiple certificateModels and assign items to an item array.
//        for ($i = 1; $i <= $num_of_plots; $i++) {
////
//            $certificatesModel[$i] = new Certificate();
//
//
//
//            $item = array(
//                'certificate_check' => 'False',
//                'certificate_doc' => '',
//                'certificates_required_id' => $input['certificate_category_id']
//            );
//
//            $certificatesModel[$i]->fill($item);
//            $items[] = $item;
//
//            //save certificate model item to Certificates table
//            $certificatesModel[$i]->save($item);
//
//
//            if ($request) {
//                $consultant = Consultant::find($request->consultant_id);
//                $consultant->certificates()->attach($certificatesModel[$i]->id);
//            }
//
//            $ids[] = $certificatesModel[$i]->id;
//        }


//
//
//
//
//        }
//        return count($ids);
//        return count($plot_arr);



        $namesArray = [
            "Building Control",
            "NHBC",
            "Site manager",
            "Architect",
            "Builder's Solicitor"
        ];
        $certificates_dev_id = CertificateCategory::whereIn('name', $namesArray)->get()->pluck('id');

//        return $certificates_dev_id;
        $certificates_dev = CertificateRequired::whereIn('certificate_category_id', $certificates_dev_id)->get();

//        return $certificates_dev

        foreach ($certificates_dev as $dev) {
            $certificates = Certificate::where('certificates_required_id', $dev['id'])->where('is_assigned', '!=', 1)->get()->take(5);
//            echo $certificates;



                for ($a = 0; $a < $num_of_plots; $a++) {
                    $count = count($certificates[$a]);
//                    $plot_id = $plot_arr[$a];
//                    echo "<h1>PLOT ID: " . $plot_arr[$a] . "</h1>";
//                    echo $plot_arr[$a] . ' '. $certificates[$a];
//                    echo "<h1>ATTACH PLOTID - ". $plot_arr[$a]." to ".$certificates[$a];

                    $plot_certificates->attach($certificates[$a], ['plot_id'=> $plot_arr[$a]]);
                    $certificates[$a]->is_assigned = 1;
                    $certificates[$a]->save();

                }
        }

//        return null;

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

    public function createCertificate(Request $request){
        $input  = $request->all();

        CertificateRequired::create($input);
        return redirect()->back();
    }

    public function getPhases(Request $request){

//        return $request->id;

//        $phases = Plot::where('house_type', $request->id)->pluck('phase')->distinct()->all();

//         $phases = Plot::where('house_type', $request->id)->distinct()->orderBy('phase', 'asc')->get(['phase']);
        $plots = Plot::where('development_id', $request->id)->distinct()->pluck('phase')->all();
//        return $plots;
        $phases = Phases::where('development_id', $request->id)->whereIn('id', $plots)->get();
//        return $phases;

        return response()->json($phases);

    }
}
