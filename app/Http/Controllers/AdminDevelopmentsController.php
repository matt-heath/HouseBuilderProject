<?php

namespace App\Http\Controllers;

use App\CertificateCategory;
use App\Development;
use App\HouseType;
use App\Http\Requests\DevelopmentsCreateRequest;
use App\Photo;
use App\Plot;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class AdminDevelopmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $developments = Development::all();

        $ids = array();

        foreach ($developments as $development){
            $id = $development['id'];

            $ids[] = $id;
        }

//        $ids[] = $id;

        $num_of_plots_available = Plot::whereIn('development_id', $ids)->get();

//        return ($num_of_plots_available);

        return view('admin.developments.index', compact('developments', 'num_of_plots_available'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::where('id', '=', 5)->pluck('name', 'id')->all();
        $consultants = User::where('role_id', '=', 5)->get()->pluck('consultant_details', 'id')->all();

        $certificates = CertificateCategory::all();

//        return $consultantEmail = User::where('id', $consultants['id'])->pluck('email')->all();

        return view('admin.developments.create', compact('roles', 'consultants', 'certificates'));
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
//        dd( $request->input() );
        return $formInput = Input::all();

        $floor_plan = $formInput['floor_plan'];
        $houseImg = $formInput['house_img'];
        $input = $request->all();
        $houseTypesArray = $request->input('house_type_name');


        if($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=> $name]);

            $input['photo_id'] = $photo->id;

        }


            if (Input::hasFile('floor_plan')) {
                $floor_plan_count = 0;
                foreach (Input::file('floor_plan') as $file) {
                    if (!isset($file)) {
                        $item[$floor_plan_count]['floor_plan'] = 0;
                    } else {
                        $name = time() . $file->getClientOriginalName();
                        $file->move('images', $name);
                        $floor_plan_photo = Photo::create(['file' => $name]);
                        $item[$floor_plan_count]['floor_plan'] = $floor_plan_photo->id;

                        echo $floor_plan_photo->id;
                    }
                    $floor_plan_count++;
                }
            }else {
            $floor_plan_count = 0;
            if (!isset(Input::file('floor_plan')[$floor_plan_count])) {
                foreach ($houseTypesArray as $houseType) {
                    $item[$floor_plan_count]['floor_plan'] = 0;
                    $floor_plan_count++;
                }
            }
        }

//        dd( Input::file('house_img'));

        if (Input::hasFile('house_img')) {
            $count = 0;
            foreach (Input::file('house_img') as $file) {
                if ($file == '') {
                    $item[$count]['house_img'] = 0;
                } else {

                    $name = time() . $file->getClientOriginalName();

                    $file->move('images', $name);
                    $photo = Photo::create(['file' => $name]);
                    $item[$count]['house_img'] = $photo->id;
                }
                $count++;
            }
        } else {
            $count = 0;
            if (!isset(Input::file('house_img')[$count])) {
                foreach ($houseTypesArray as $houseType) {
                    $item[$count]['house_img'] = 0;
                    $count++;
                }
            }
        }

        $development = Development::create($input);
        $dev_id = $development->id;




//        dd(Input::file('floor_plan'));

        for ($i = 0; $i < count($houseTypesArray); $i++) {
            if ($file = $request->file('floor_plan')) {

                echo "hi";
//                dd($request->file('floor_plan'));
//                dd($request->file('house_img'));
            }

//            if($input['floor_plan'][$i] == ''){
//                echo "SHIT";
//            }

            $item = array(
                'development_id' => $dev_id,
                'house_type_name' => $input['house_type_name'][$i],
                'house_type_desc' => $input['house_type_desc'][$i],
                'floor_plan' => !isset($floor_plan[$i]) ? 0 : $floor_plan_photo->id,
                'house_img' => !isset($houseImg[$i]) ? 0 : $photo->id
            );

//            if (!isset(Input::all()->floor_plan[$i])) {
//                $item[$i]['floor_plan'] = 0;
//                echo $i;
////                echo Input::all()->floor_plan[$i];
//            }


            $items[] = $item;
//            dd( Input::all() );


        }




//
//        dd( $items);
//
//
        HouseType::insert($items);

        return redirect('/admin/developments');
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
        return view('admin.developments.show');
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

        $development = Development::findOrFail($id);

        return view('admin.developments.edit', compact('development'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DevelopmentsCreateRequest $request, $id)
    {
        //

        $input = $request->all();
        $development = Development::findOrFail($id);

        if($file = $request->file('photo_id')){

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=> $name]);

            $input['photo_id'] = $photo->id;

        }

//        dd(Auth::user()->developments()->whereId($id)->first()->update($input);

        $development->update($input);

        return redirect('/admin/developments');
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
        $development = Development::findOrFail($id); // find user and delete.

        if($development->photo_id){
            unlink(public_path() . $development->photo->file);
        }

        $development->delete();

        Session::flash('deleted_development', 'The development has been deleted');

        return redirect('/admin/developments'); // upon deletion, redirect to users table.

    }


    public function development($id) {
        $development = Development::findOrFail($id);

         $plots = Plot::where('development_id', $id)->get();
//         $plots->where('development_id', '=', $id);


        return view('development', compact('development', 'plots'));
    }
}
