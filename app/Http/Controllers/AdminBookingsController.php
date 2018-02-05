<?php

namespace App\Http\Controllers;

use App\Booking;
use App\CertificateCategory;
use App\Consultant;
use App\HouseType;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminBookingsController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bookings = Booking::all();

        return view('/admin/booking/index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $users = User::where('role_id', 4 )->lists('name', 'id')->all();
//        $plots = Plot::where('id', $id)->pluck('development_id');
//        $developments = Development::where('id', $plots)->get();
//        $houseTypes = HouseType::lists('house_type_name', 'id')->all();
        return view('/estateagent/booking/create', compact('users','id', 'plots', 'development_name'));
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

        $input['plot_id'] = $input['id'];

        Booking::create($input);

        if($input){
            $plot = Plot::findOrFail($input['plot_id']);
            $plot->status = 'Reserved';
            $plot->save();
        }

        return redirect('/estateagent/developments');
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
        $booking = Booking::findOrFail($id);
        $certificates = CertificateCategory::lists('name', 'id')->all();
        $consultants = Consultant::all();


        $options = [];

        foreach ($consultants as $consultant){
            $options[$consultant->id] = $consultant->user->name;
        }



//        foreach($consultants as $consultant){
//            $name = $consultant['user_id'];
//
//            $consultant_names[] = $name;
//        }

//        $users = User::whereIn('id', $consultant_names)->lists('name','id')->all();

//        $consultant_names[] = $names;

//        $ids = array();
//
//        foreach ($developments as $development){
//            $id = $development['id'];
//
//            $ids[] = $id;
//        }


//        $ids[] = $id;

//        $num_of_plots_available = Plot::whereIn('development_id', $ids)->get();

//        return count($consultants->certificates);

//        $houseTypes = HouseType::all();
//
//        foreach($houseTypes as $houseType){
//            return $floorplan = $houseType->floor_plan;
//        }


//        return $user = User::where('id', $consultants['user_id']);


//        Consultant::has('user')->get();


//        return $user = User::where('id', $consultants->user_id)->lists('id', 'name');
        return view('admin.booking.show', compact('booking', 'certificates', 'consultant_names', 'options'));
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
        $booking = Booking::findOrFail($id);

        return view('estateagent.booking.edit', compact('booking'));
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
        $booking = Booking::findOrFail($id);

        $booking->update($input);

        return redirect('/estateagent/booking');
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
        $booking = Booking::findOrFail($id);
        $plot = Plot::where('id', $booking->plot_id)->first();
        $plot->status = 'For Sale';
        $plot->save();
        $booking->delete();

        Alert::success('Booking deleted from the system.')->flash();

        return redirect('/estateagent/booking');
    }

    public function findUsersEmail(Request $request) {
//        return $request->id;
        $data = User::where('id', $request->id)->pluck('email')->first();
        return response()->json($data);
    }
}
