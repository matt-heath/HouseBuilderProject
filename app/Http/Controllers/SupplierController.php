<?php

namespace App\Http\Controllers;

use App\SelectionCategory;
use App\Supplier;
use App\Variation;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $suppliers = Supplier::all();

        return view('admin.suppliers.index', compact('suppliers'));
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
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
//        return $id;
        $supplier = Supplier::where('id', $id)->first();
        $variations = Variation::where('supplier_id', $id)->get();
        $categories = SelectionCategory::all();



        return view('admin.suppliers.show', compact('supplier', 'variations', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::where('id', $id)->first();
        $default = $supplier->selectionCategory()->first();
//        return $default->category_name;
        $selectionCategories = SelectionCategory::all()->where('category_name', '!==', $default->category_name)->pluck('category_name', 'id');
        $default = $supplier->selectionCategory()->pluck('category_name','id');


        return view('admin.suppliers.edit', compact('supplier','default', 'selectionCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        return $id;
        $input = $request->all();

        $supplier = Supplier::findOrFail($id);

        $supplier->update($input);

        return redirect('/admin/suppliers/'.$supplier->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
