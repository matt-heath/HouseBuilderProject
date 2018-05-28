<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Development;
use App\HouseType;
use App\Plot;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prologue\Alerts\Facades\Alert;

class EstateAgentBookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bookings = Booking::all();

        return view('/estateagent/booking/index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $users = User::doesntHave('booking')->where('role_id', 4 )->pluck('name', 'id')->all();
        $plot = Plot::where('id', $id)->first();
        $image = HouseType::where('id', $plot->house_type)->first();
        $roles = Role::where('id', 4)->pluck('name','id')->all();
        $dev_id = Plot::where('id', $id)->pluck('development_id')->first();
//        $developments = Development::where('id', $plots)->get();
//        $houseTypes = HouseType::pluck('house_type_name', 'id')->all();

        return view('/estateagent/booking/create', compact('users','id', 'plot', 'development_name', 'image', 'roles', 'dev_id'));
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
//        return null;

        $input = $request->all();

//        return $input['dev_id'];

        $input['plot_id'] = $input['id'];

        Booking::create($input);

        if($input){
            $plot = Plot::findOrFail($input['plot_id']);
            $plot->status = 'Reserved';
            $plot->save();
        }

        Alert::success('Booking successfully added!')->flash();


        return redirect('/estateagent/developments/'. $input['dev_id']);
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
        Alert::success('Booking successfully updated!')->flash();


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
