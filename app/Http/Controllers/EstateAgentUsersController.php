<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersEditRequest;
use App\Http\Requests\UsersRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Prologue\Alerts\Facades\Alert;

class EstateAgentUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO: Change role id so it isn't hard-coded in.
        $users = User::where('role_id', 4 )->get();

        return view('estateagent.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $roles = Role::where('name', 'Buyer')->pluck('name', 'id')->all();

        return view('estateagent.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        //

        if(trim($request->password) == ''){

            $input = $request->except('password');

        } else{


            $input = $request->all();

            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
            ]);

            $input['password'] = bcrypt($request->password);

        }


        User::create($input);


        return redirect('/estateagent/users');

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
        $user = User::findOrFail($id);

        $roles = Role::where('name', 'Buyer')->pluck('name', 'id')->all();

        return view('estateagent.users.edit', compact('user','roles'));
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
        //

        $user = User::findOrFail($id);

        if(trim($request->password) == ''){

            $input = $request->except('password');

        } else{

            $input = $request->all();
            $input['password'] = bcrypt($request->password);

        }


        $user->update($input);

        return redirect('/estateagent/users');
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
        $user = User::findOrFail($id); // find user and delete.
//        unlink(public_path() . $user->photo->file);

        $user->delete();

        Session::flash('deleted_user', 'The user has been deleted');

        return redirect('/estateagent/users'); // upon deletion, redirect to users table.
    }

    public function addBuyer(Request $request){
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

            Alert::success('User added to the system.')->flash();
        }

//        $data = User::where('role_id', '=', 5)->all();

//        $consultants = User::where('role_id', '=', 5)->get()->pluck('consultant_details', 'id')->all();

//        return $data;
//        TODO:: add success notification
        return response()->json($addUserModel);
    }
}
