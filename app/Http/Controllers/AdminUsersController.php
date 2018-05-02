<?php

namespace App\Http\Controllers;

use App\Consultant;
use App\Http\Requests\UsersEditRequest;
use App\Http\Requests\UsersRequest;
use App\Photo;
use App\Role;
use App\Supplier;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Prologue\Alerts\Facades\Alert;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $users = User::all();
        $roles = Role::pluck('name','id')->all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::pluck('name','id')->all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        $userModel = new User();
        if(trim($request->password) == ''){
            $input = $request->except('password');
        } else{
            $input = $request->except('consultant_description', 'supplier_company_name', 'supplier_type');
            $this->validate($request, [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6',
                ]);
            $input['password'] = bcrypt($request->password);
        }

        $userModel->fill($input);
        $userModel->save();
        $consultant_user_id = $userModel->id;
        $supplier_user_id = $userModel->id;

        if($request->consultant_description){
            $consultant_description = $request->consultant_description;
            $data = [
                'user_id' => $consultant_user_id,
                'consultant_description' => $consultant_description
            ];

            Consultant::create($data);
        }elseif ($request->supplier_company_name){
            $supplier_company_name = $request->supplier_company_name;
            $supplier_type = $request->supplier_type;

            $data = [
                'user_id' => $supplier_user_id,
                'supplier_company_name' => $supplier_company_name,
                'supplier_type' => $supplier_type
            ];
            Supplier::create($data);
        }
        return redirect('/admin/users');
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
        return view('admin.users.show');
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

        $user = User::findOrFail($id);

        $roles = Role::pluck('name', 'id')->all();

        return view('admin.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if(trim($request->password) == ''){
            $input = $request->except('password');
        }else{
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }

        $user->update($input);
        Alert::success('User details successfully edited!')->flash();

        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id); // find user and delete.
        $user->delete();
        Session::flash('deleted_user', 'The user has been deleted');
        return redirect('/admin/users'); // upon deletion, redirect to users table.
    }

    public function viewUserByRole($id){
        $users = User::where('role_id', $id)->get();
//        $development_name = Development::where('id', $id)->pluck('development_name')->first();
        $role_name = Role::where('id', $id)->pluck('name')->first();

        return view('/admin/users/viewuserbyrole', compact('users', 'role_name'));
    }

    public function addUser(Request $request){
        $all = $request->all();

        if(isset($all)) {
            $addUserModel = new User();

            if (trim($request->password) == '') {

                $input = $request->except('password');

            } else {
                $input = $request->except('consultant_description');

                $this->validate($request, [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6',
                ]);

                $input['password'] = bcrypt($request->password);

            }
            //        return $input;

            $addUserModel->fill($input);
            $addUserModel->save();

            $consultant_user_id = $addUserModel->id;
            $supplier_user_id = $addUserModel->id;

            if ($request->consultant_description) {
                $consultant_description = $request->consultant_description;
                $data = [
                    'user_id' => $consultant_user_id,
                    'consultant_description' => $consultant_description
                ];

                Consultant::create($data);
            }elseif ($request->supplier_company_name){
                $supplier_company_name = $request->supplier_company_name;
                $supplier_type = $request->supplier_type;

                $data = [
                    'user_id' => $supplier_user_id,
                    'supplier_company_name' => $supplier_company_name,
                    'supplier_type' => $supplier_type
                ];

                Supplier::create($data);
            }

            Alert::success('User added to the system.')->flash();
        }

//        $data = User::where('role_id', '=', 5)->all();

//        $consultants = User::where('role_id', '=', 5)->get()->pluck('consultant_details', 'id')->all();

//        return $data;
//        TODO:: add success notification
        return response()->json($addUserModel);
    }

    public function getUsers(){
        $users = User::all();

        return $users;
    }
}
