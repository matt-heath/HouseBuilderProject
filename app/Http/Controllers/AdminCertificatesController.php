<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\CertificateCategory;
use App\Consultant;
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
        $certificatesModel = new Certificate();
        $input = $request->all();


        if($file = $request->file('certificate_doc')){

            $name = time() . $file->getClientOriginalName();

            $file->move('documents', $name);

//            Certificate::create(['certificate_doc'=> $name]);

            $input['certificate_doc'] = $name;

        }

//        Certificate::create($input);

        $certificatesModel->fill($input);
        $certificatesModel->save();

//        return $input;

        if($request){
//            $data = [
//                'user_id' => $consultant_user_id,
//                'consultant_description' => $consultant_description
//            ];

//            $certificate = Certificate::find($certificatesModel->id);
//            $certificate->consultant()->attach($request->consultant_id);

            $consultant = Consultant::find($request->consultant_id);
            $consultant->certificates()->attach($certificatesModel->id);
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
