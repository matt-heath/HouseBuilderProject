<?php

namespace App\Http\Controllers;

use App\Booking;
use App\HouseType;
use App\Plot;
use App\SelectionCategory;
use Illuminate\Http\Request;

class BuyerVariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

//        return $id;

        $booking = Booking::where('id', $id)->first();
        $plot = Plot::where('id', $booking->plot_id)->first();
        $houseType = HouseType::where('id', $plot->house_type)->first();

//        $variations = $houseType->variations()->get();
//        $assignedSuppliers = $development->suppliers()->get();

        $variation_ids = $houseType->variations()->get();

        $items = array();
        foreach ($variation_ids as $variation_id){
//            echo $variation_id->pivot;

            $item = $variation_id->pivot->variation_id;

            $items[] = $item;
        }

//        return $items;
        $selectionTypes = array();
        foreach($variation_ids as $value){
            $selectionType = $value->selectionType;

            $selectionTypes[] = $selectionType;
        }

//        return $selectionTypes;
        $booking = Booking::where('id', $id)->first();
        $selectionCategories = SelectionCategory::all();
        $default = $booking->variations()->pluck('variation_id')->toArray();

//        return $default;

        return view('buyer.variations.edit', compact('booking', 'plot', 'houseType', 'supplier_categories', 'items', 'variation_ids', 'selectionCategories', 'selectionTypes', 'default'));

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
        $booking_id = $id;
        $input = $request->all();
        $variations = $input['variations'];
        $num_of_variations = count($input['variations']);
        $booking = Booking::where('id', $booking_id)->first();
        $variation_ids = $booking->variations()->get();

        $items = array();
        foreach($variation_ids as $variation_id){
            $item = [
                $variation_id->pivot->variation_id
            ];
            $items[] = $item;
        }
        foreach($variations as $variation){
            foreach($items as $item){
                if($item !== $variation){
                    $booking->variations()->detach($item);
                }
            }
            $booking->variations()->attach($variation);
        }

        return "DONE";
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
