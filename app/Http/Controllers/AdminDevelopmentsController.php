<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\CertificateCategory;
use App\CertificateRequired;
use App\Consultant;
use App\Development;
use App\EstateAgent;
use App\HouseType;
use App\Http\Requests\DevelopmentsCreateRequest;
use App\Phases;
use App\Photo;
use App\Plot;
use App\Role;
use DB;
use App\SelectionCategory;
use App\Supplier;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Prologue\Alerts\Facades\Alert;

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
        $estate_select = Role::where('id', '=', 2)->pluck('name', 'id')->all();
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
        $estate_select = User::where('role_id', '=', 2)->get()->pluck('supplier_details', 'id')->all();
        $certificates = CertificateCategory::whereIn('name', $namesArray)->get();
        $supplier_types_select = $supplier_types->pluck('category_name', 'id')->all();

//        return $consultantEmail = User::where('id', $consultants['id'])->pluck('email')->all();

        return view('admin.developments.create', compact('roles', 'consultants', 'certificates', 'supplier_types', 'suppliers', 'supplierRoles', 'supplier_types_select', 'estate_select'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formInput = Input::all();
        $number_of_plots = $formInput['phase_num_plots'];
        $supplier_id = $formInput['supplier_id'];
        $consultant_id = $formInput['consultant_id'];
        $cert_name = $formInput['certificate_name'];
        $phase_name = $formInput['phase_name'];
        $num_of_plots = 0;
        $items = array();
        $itemsHouseType = array();
        $phases_arr = array();
        $ids = array();
        $input = $request->all();
        $houseTypesArray = $request->input('house_type_name');

        foreach($number_of_plots as $num_plot){
            $num_of_plots += $num_plot;
        }
        $input['development_num_plots'] = $num_of_plots;

        if(array_filter($consultant_id)){
            for($z = 0; $z< count($cert_name); $z++){
                $certificates = CertificateRequired::where('certificate_category_id', '=', $cert_name[$z])->get();
                foreach($certificates as $certificate){
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
        }

        if (isset($formInput['floor_plan'])) {
            $floor_plan = $formInput['floor_plan'];
        }
        if (isset($formInput['house_img'])) {
            $houseImg = $formInput['house_img'];
        }

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
        }else {
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
        $estate_agent = $input['estate_agent_responsible'];
        $estate_insert = EstateAgent::where('user_id', $estate_agent)->get()->pluck('id')->first();
        $development_insert = Development::where('id', '=', $dev_id)->first();

        $development_insert->estateAgent()->attach($estate_insert);

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
        Phases::insert($phases_arr);

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
//        Alert::success('Development added to the system.')->flash();
        Alert::success('Development details successfully added to the system!')->flash();
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
        $certificatesCategory = CertificateCategory::where('name', 'Tradesmen certificates')->get()->pluck('id');
        $certificates = CertificateRequired::where('certificate_category_id', $certificatesCategory)->get();
        $consultants = User::where('role_id', '=', 5)->get()->pluck('consultant_details', 'id')->all();
        $roles = Role::where('id', '=', 5)->pluck('name', 'id')->first();


        // $phaseCount = Plot::all()->groupBy('phase');

        $phaseCount = DB::table('plots')
            ->select('phase', DB::raw('count(*) as total'))
            ->where('development_id', $id)
            ->groupBy('phase')->get()->toArray();

        $phases = Phases::where('development_id', $id)->get();
        // return $phases->num_plots;

        $phaseArray = array();
        foreach($phases as $phase){
            foreach($phaseCount as $test){
//                 echo $phase->id. ' ' .$phase->num_plots.'<br>';
//                 return $test->phase;
                if($phase->id == $test->phase){
                    if($phase->num_plots !== $test->total){
//                         echo $phase->num_plots. ' '. $test->total;
//                         return "MAX NOT REACHED";
                        $phaseArr = [
                            $phase->id
                        ];
                        // return $phaseArr;
                        $phaseArray[] = $phaseArr;
                    }else{
//                         echo $phase->phase_name. " MAX REACHED <br>";
//                         echo "NOT EQUAL";
                    }
                }else if(!$test->phase){
//                     return  "NO PLOTS in ". $phase->phase_name;
                    $phaseArr = [
                            $phase->id
                        ];
                        // return $phaseArr;
                    $phaseArray[] = $phaseArr;
                }
            }

            if(!$phaseCount){
                $phaseArr = [
                    $phase->id
                ];
                $phaseArray[] = $phaseArr;
            }
        }

        $phases = Phases::whereIn('id', $phaseArray)->get()->pluck('phase_name', 'id')->all();
        $phase = Phases::where('development_id', $id)->where('is_assigned', '!==', 1)->first();

        $supplier_types = SelectionCategory::all();
        $suppliers = User::where('role_id', '=', 3)->get()->pluck('supplier_details', 'id')->all();
        $default = $development->suppliers()->pluck('supplier_company_name','id');
        $estate_agent = $development->estateAgent()->first();


        $items = array();
        $assigned = array();

        foreach($development->suppliers as $supplier) {
            $details = $supplier->selectionCategory->toArray();
            $items[] = $details;
        }

        for($i = 0; $i < count($items); $i++){
            $assigned[] = $items[$i];
        }

        $development_select = $development::where('id', $id)->pluck('development_name','id');
        $houseTypes_select = HouseType::where('development_id', $id)->get()->pluck('house_type_name', 'id')->all();

        return view('admin.developments.show', compact('plots', 'development', 'num_of_plots_available',
            'houseTypes', 'supplier_types', 'suppliers', 'default', 'assigned', 'estate_agent', 'development_select', 'houseTypes_select', 'phases', 'certificates', 'consultants',
            'phase', 'roles'));
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

        $default = $development->estateAgent()->first();
        $default = User::where('id', $default->user_id)->get()->pluck('supplier_details', 'id')->all();
        $estate_select = User::where('role_id', '=', 2)->get()->pluck('supplier_details', 'id')->all();



        return view('admin.developments.edit', compact('development', 'estate_select', 'default'));
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

        $input = $request->all();
        $previousEstateAgentID='';
        $development = Development::where('id', $id)->first();
        $default = $development->estateAgent()->get()->first();

        if($default){
            $assignedEstateAgent = EstateAgent::where('id', $default->id)->get();
            $previousEstateAgentID = $assignedEstateAgent->pluck('id')->first();
        }

        $development = Development::where('id', $id)->first();
        if($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file'=> $name]);
            $input['photo_id'] = $photo->id;
        }
        $previousEstateAgentID = $assignedEstateAgent->pluck('id')->first();
        $newEstateAgent = EstateAgent::where('user_id', $input['estate_agent_responsible'])->pluck('id')->first();

        $development->update($input);
        $val = $development->estateAgent()
            ->updateExistingPivot($previousEstateAgentID, ['estate_agent_id' => $newEstateAgent]);
        Alert::success('Development details successfully updated!')->flash();
        return redirect('/admin/developments/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $development = Development::findOrFail($id); // find user and delete.
        if($development->photo_id){
            unlink(public_path() . $development->photo->file);
        }
        $development->delete();
//        Session::flash('deleted_development', 'The development has been deleted');
        Alert::info('The development has been deleted')->flash();
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
        $previousSupplierID = $request->previousSupplierID;
        $supplier_id = $request->supplier_id;
        $development_id = $request->development_id;
        $supplier = Supplier::where('id', $supplier_id)->first();
        $development_insert = Development::where('id', '=', $development_id)->first();

        $val = $development_insert->suppliers()
            ->wherePivot('supplier_type', $supplier->supplier_type)
            ->wherePivot('development_id', $development_id)
            ->updateExistingPivot($previousSupplierID, ['supplier_id' => $supplier->id]);

        if(empty($val)) {
            $development_insert->suppliers()->attach($supplier->id, ['supplier_type' => $supplier->supplier_type]);
        }
        Alert::success('Supplier added to development!')->flash();

        return redirect('/admin/developments/'.$development_id);
    }
}
