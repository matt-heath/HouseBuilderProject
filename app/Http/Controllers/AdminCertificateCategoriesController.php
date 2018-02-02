<?php

namespace App\Http\Controllers;

use App\CertificateCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prologue\Alerts\Facades\Alert;

class AdminCertificateCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $categories = CertificateCategory::all();


        return view('admin.certificatecategories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.certificatecategories.create');

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
        $input = $request->all();
        CertificateCategory::create($input);
        Alert::success('Certificate category successfully added!')->flash();

        return redirect('/admin/certificatecategories');
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
        $category = CertificateCategory::findOrFail($id);
        return view('admin.certificatecategories.edit', compact('category'));
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
        $category = CertificateCategory::findOrFail($id);
        $category->update($input);

        return redirect('/admin/certificatecategories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($request)
    {
        //
//        return $request;
        $id = $request;
        $category = CertificateCategory::findOrFail($id); // find user and delete.

        $category->delete();

        return redirect('/admin/certificatecategories'); // upon deletion, redirect to users table.
    }
}
