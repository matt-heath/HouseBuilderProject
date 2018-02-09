<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\CertificateCategory;
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
        $certificates = CertificateCategory::lists('name', 'id')->all();
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
        $input = $request->all();

        $items = array();
        $ids = array();
        $plot_arr = array();

        $plots = Plot::where('plot_name_id', '<=', $request->selected_plots)->where('house_type', $request->house_type)->get();


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

             echo $ids[] = $certificatesModel[$i]->id;
        }

        for($z = 0; $z < count($ids); $z++){

            $plot_id = $plot_arr[$z];

            var_dump( $plot_id);

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

        return view('admin.certificates.index');
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
}
