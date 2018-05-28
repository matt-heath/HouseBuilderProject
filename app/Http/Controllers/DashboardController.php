<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Certificate;
use App\Consultant;
use App\Development;
use App\EstateAgent;
use App\HouseType;
use App\Plot;
use App\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function admin()
    {

        $developments = Development::all()->count();
        $plots = Plot::all()->count();
        $houseTypes = HouseType::all()->count();
        $certificates = Certificate::where('certificate_check', '=', '0')->where('build_status', '=', 'Awaiting approval')->get()->count();

        return view('admin.index', compact('developments', 'plots', 'houseTypes', 'certificates'));
    }

    public function estateAgent()
    {
        $userId = Auth::id();
//        with('certificates')->where('user_id', $user_id)->first()
        $estateAgent = EstateAgent::where('user_id', $userId)->first();
        $developments = $estateAgent->developments()->get();


        $ids = array();

        foreach ($developments as $development) {
            $id = $development['id'];

            $ids[] = $id;
        }

        $development = $developments->count();
        $plots = Plot::all()->count();
        $plot_ids = Plot::whereIn('development_id', $ids)->get()->pluck('id');

        $plots = $plot_ids->count();

        $bookings = Booking::whereIn('plot_id', $plot_ids)->count();

        $houseTypes = HouseType::all()->count();
//        $bookings = Booking::where()

        return view('estateagent.index', compact('developments', 'development', 'plots', 'houseTypes', 'bookings'));
    }

    public function buyer()
    {
        $userId = Auth::id();
        $booking = Booking::where('user_id', $userId)->pluck('id');

        $variations = Variation::whereHas('booking', function ($query) use ($booking) {
            $query->whereIn('booking_id', $booking);
        })->get();

        $booking = $booking->first();

        $variation_count = $variations->count();

        return view('buyer.index', compact('booking', 'variations', 'variation_count'));

    }

    public function externalConsultant()
    {
        $userId = Auth::id();
//        $booking = Booking::where('user_id', $userId)->pluck('id');
//
        $consultants = Consultant::with('certificates')->where('user_id', $userId)->first();


//        return $consultants->pluck('id')

//        $consultant->certificates()->attach($certificatesModel->id);

        foreach ($consultants->certificates as $consultant) {
//            echo "Certificate: $consultant->certificate_name, pivot value: $consultant->pivot";

//            echo $consultant;
            $certificate_id = $consultant->pivot->certificate_id;
            $certificate_required_ids[]= $consultant->certificates_required_id;
            $certificate_ids[] = $certificate_id;
        }

        $plots = Plot::whereHas('certificates', function ($query) use ($certificate_ids) {
            $query->whereIn('certificate_id', $certificate_ids);
        })->get();
        $plots_count = $plots->count();

        $certificates = Certificate::whereIn('id', $certificate_ids)->where('build_status', '=','Ready for inspection')->get()->count();
        $totalCert = Certificate::whereIn('id', $certificate_ids)->get()->count();

//
//        $variation_count = $variations->count();

        return view('externalConsultant.index', compact('plots_count', 'certificates', 'totalCert'));

    }
}
