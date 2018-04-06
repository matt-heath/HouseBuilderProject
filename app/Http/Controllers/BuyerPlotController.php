<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Development;
use App\HouseType;
use App\SelectionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerPlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $booking = Booking::where('user_id', $user_id)->first();
        $plot = $booking->plot()->first();
        $image = HouseType::where('id', $plot->house_type)->first();

        $houseType = HouseType::where('id', $plot->house_type)->first();
        $supplier_categories = SelectionCategory::all();

        $development = Development::where('id', $houseType->development_id)->first();
        $assignedSuppliers = $development->suppliers()->get();

        $variation_ids = $houseType->variations()->get();

        $items = array();
        foreach ($variation_ids as $variation_id){
//            echo $variation_id->pivot;

            $item = $variation_id->pivot->variation_id;

            $items[] = $item;
        }

        return view('buyer.plot.index', compact('booking', 'plot', 'image', 'houseType', 'supplier_categories', 'assignedSuppliers', 'items'));
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
