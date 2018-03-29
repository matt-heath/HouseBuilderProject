<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\CertificateCategory;
use App\CertificateRequired;
use App\Consultant;
use App\Development;
use App\HouseType;
use App\Http\Requests\DevelopmentsCreateRequest;
use App\Phases;
use App\Photo;
use App\Plot;
use App\Role;
use App\SelectionCategory;
use App\Supplier;
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
        $supplierRoles = Role::where('id', '=', 3)->pluck('name', 'id')->all();
        $consultants = User::where('role_id', '=', 5)->get()->pluck('consultant_details', 'id')->all();

        $namesArray = [
            "Building Control",
            "NHBC",
            "Site manager",
            "Architect",
            "Builder's Solicitor"
        ];

        $supplier_types = SelectionCategory::all();
        $suppliers = User::where('role_id', '=', 3)->get()->pluck('supplier_details', 'id')->all();
        $certificates = CertificateCategory::whereIn('name', $namesArray)->get();
        $supplier_types_select = $supplier_types->pluck('category_name', 'id')->all();

//        return $consultantEmail = User::where('id', $consultants['id'])->pluck('email')->all();

        return view('admin.developments.create', compact('roles', 'consultants', 'certificates', 'supplier_types', 'suppliers', 'supplierRoles', 'supplier_types_select'));
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
//        return $request->input();
//        dd( $request->input() );
        $formInput = Input::all();
        $number_of_plots = $formInput['phase_num_plots'];



        $supplier_id = $formInput['supplier_id'];
        $category_id = $formInput['category_name'];

        $num_of_plots = 0;
        foreach($number_of_plots as $num_plot){
            $num_of_plots += $num_plot;
        }


        $consultant_id = $formInput['consultant_id'];
        $items = array();
        $itemsHouseType = array();
        $phases_arr = array();
        $ids = array();

        $cert_name = $formInput['certificate_name'];
        $phase_name = $formInput['phase_name'];



        for($z = 0; $z< count($cert_name); $z++){
            $certificates = CertificateRequired::where('certificate_category_id', '=', $cert_name[$z])->get();

            foreach($certificates as $certificate){
//                echo "<h1>".$consultant_id[$z]."</h1>";
                for ($i = 0; $i < $num_of_plots; $i++) {
                    $certificatesModel[$i] = new Certificate();

                    $item = array(
                        'certificate_check' => 'False',
                        'certificate_doc' => '',
                        'certificates_required_id' => $certificate->id
                    );

                    $certificatesModel[$i]->fill($item)->save();

                    $items[] = $item;

                    $ids[] = $certificatesModel[$i]->id;

                    $consultant = Consultant::where('user_id', $consultant_id[$z])->first();
                    $consultant->certificates()->attach($certificatesModel[$i]->id);
                }
            }
        }

        if (isset($formInput['floor_plan'])) {
            $floor_plan = $formInput['floor_plan'];
        }
        if (isset($formInput['house_img'])) {
            $houseImg = $formInput['house_img'];
        }

        $input = $request->all();
        $houseTypesArray = $request->input('house_type_name');

        $input['development_num_plots'] = $num_of_plots;


        if ($file = $request->file('photo_id')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
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
                }
                $floor_plan_count++;
            }
        } else {
            $floor_plan_count = 0;
            if (!isset(Input::file('floor_plan')[$floor_plan_count])) {
                foreach ($houseTypesArray as $houseType) {
                    $item[$floor_plan_count]['floor_plan'] = 0;
                    $floor_plan_count++;
                }
            }
        }

        if (Input::hasFile('house_img')) {
            $count = 0;
            foreach (Input::file('house_img') as $file) {
                if ($file == '') {
                        $item[$count]['house_img'] = 0;
                }else {
                    $name = time() . $file->getClientOriginalName();
                    $file->move('images', $name);
                    $photo = Photo::create(['file' => $name]);
                    $item[$count]['house_img'] = $photo->id;
                }
                $count++;
            }
        }else {
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
        $development_insert = Development::where('id', '=', $dev_id)->first();

        for($z = 0; $z< count($supplier_id); $z++){
            if($supplier_id[$z] !== ''){
                $supplier = Supplier::where('user_id', $supplier_id[$z])->first();

                $development_insert->suppliers()->attach($supplier->id);
            }
        }

        for($p = 0; $p < count($phase_name); $p++){
            $itemsPhases = array(
                'development_id' => $dev_id,
                'phase_name' => $phase_name[$p],
                'num_plots' => $number_of_plots[$p]
            );

            $phases_arr[] = $itemsPhases;
        }
//        return $itemsPhases;
        Phases::insert($phases_arr);

//        return null;

        for ($i = 0; $i < count($houseTypesArray); $i++) {
            $itemHouseType = array(
                'development_id' => $dev_id,
                'house_type_name' => $input['house_type_name'][$i],
                'house_type_desc' => $input['house_type_desc'][$i],
                'floor_plan' => !isset($floor_plan[$i]) ? 0 : $item[$i]['floor_plan'],
                'house_img' => !isset($houseImg[$i]) ? 0 : $item[$i]['house_img']
            );

                $itemsHouseType[] = $itemHouseType;
        }

        HouseType::insert($itemsHouseType);

//        return null;
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
        $development = Development::with('suppliers')->where('id', $id)->first();
        $plots = Plot::where('development_id', $id)->get();
        $num_of_plots_available = Plot::where('development_id', $id)->get();
        $houseTypes = HouseType::where('development_id', $id)->get();
        $supplier_types = SelectionCategory::all();
        $suppliers = User::where('role_id', '=', 3)->get()->pluck('supplier_details', 'id')->all();
        $default = $development->suppliers()->pluck('supplier_company_name','id');


        $items = array();
        $assigned = array();

        foreach($development->suppliers as $supplier) {
            $details = $supplier->selectionCategory->toArray();
            $items[] = $details;
        }

        for($i = 0; $i < count($items); $i++){
            $assigned[] = $items[$i];
        }

        return view('admin.developments.show', compact('plots', 'development', 'num_of_plots_available', 'houseTypes', 'supplier_types', 'suppliers', 'default', 'assigned'));
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

    public function assignSupplier($devID, $id){
        $assignedSupplier ='';
        $previousSupplierID='';
        $development = Development::where('id', $devID)->first();
        $supplier_types = SelectionCategory::where('id', $id)->first();
        $supplier_types_select = $supplier_types->pluck('category_name', 'id')->all();
        $default = $development->suppliers()->get()->where('supplier_type', $id)->first();

        if($default){
            $assignedSupplier = Supplier::where('user_id', $default->user_id)->get();
            $previousSupplierID = $assignedSupplier->pluck('id')->first();
            $assignedSupplier = $assignedSupplier->pluck('supplier_company_name', 'id')->all();
        }

        $suppliers = Supplier::where('supplier_type', $id)->get()->pluck('supplier_company_name', 'id')->all();

        return view('admin.developments.assignSupplier', compact('supplier_types', 'suppliers', 'supplier_types_select', 'devID', 'assignedSupplier', 'previousSupplierID'));
    }

    public function assignSupplierStore(Request $request){
//        return $request->all();
        $previousSupplierID = $request->previousSupplierID;
        $supplier_id = $request->supplier_id;
        $development_id = $request->development_id;
        $supplier = Supplier::where('id', $supplier_id)->first();
        $development_insert = Development::where('id', '=', $development_id)->first();

        $val = $development_insert->suppliers()
            ->wherePivot('supplier_type', $supplier->supplier_type)
            ->wherePivot('development_id', $development_id)
            ->updateExistingPivot($previousSupplierID, ['supplier_id' => $supplier->id]);

//        echo "DONE:". $val;

        if(empty($val)) {
            $development_insert->suppliers()->attach($supplier->id, ['supplier_type' => $supplier->supplier_type]);
        }

        return redirect('/admin/developments/'.$development_id);
    }
}
