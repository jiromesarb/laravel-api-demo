<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Validator;
use Mail;
use App\User;
use App\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'asc');

        // Filter Users
        $show = !empty($request->show) ? $request->show : 10;
        $users = $users->with(['role'])->get();

        return apiReturn($users);
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
        // Validate Request
        $v = Validator::make($request->all(), [
            'name' => 'required|min:4|max:255',
			'email' => 'required|email|unique:users,email',
            'user_role' => 'required',
		]);
        if ($v->fails()) return apiReturn($request->all(), 'Validation Failed', 'failed', [$v->errors()]);

        // Insert Default Password
        $password = substr(sha1(mt_rand()),17,6);
        $request['password'] = bcrypt($password);

        // Insert data
        if(User::create($request->all())){

			$params = [
                'name' => $request->name,
                'email' => $request->email,
				'password' => $password,
			];
            $to = $request->email;

			Mail::send('mail.password-email', $params, function ($m) use($request, $to) {
				$m->subject('Default Password');
				$m->to($to);
			});

            return apiReturn($request->all(), 'Successfully Added!');
        } else {
            return apiReturn($request->all(), 'Failed to Create.', 'failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();
        if(!empty($user)){

            return apiReturn($user, 'Successfully Updated!');
        } else {
            return apiReturn([], 'Invalid User.', 'failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        if(!empty($user)){

            return apiReturn($user, 'Successfully Updated!');
        } else {
            return apiReturn([], 'Invalid User.', 'failed');
        }
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
        // Validate Request
        $v = Validator::make($request->all(), [
            'name' => 'required|min:4|max:255',
			'email' => 'required|email|unique:users,email,' . $id,
            'user_role' => 'required',
		]);
        if ($v->fails()) return apiReturn($request->all(), 'Validation Failed', 'failed', [$v->errors()]);

        // Update data
        $user = User::where('id', $id)->first();
        if(!empty($user)){

            $user->update($request->except('_method'));

            return apiReturn($request->all(), 'Successfully Updated!');
        } else {
            return apiReturn($request->all(), 'Invalid User.', 'failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(User::where('id', $id)->delete()){

            return apiReturn($id, 'Successfully Deleted!');
        } else {
            return apiReturn($id, 'Failed to delete.', 'failed');
        }
    }

    public function getRoles(){

        $roles = Role::get();
        if(!empty($roles)){

            return apiReturn($roles, 'Successfully Updated!');
        } else {
            return apiReturn([], 'Invalid User.', 'failed');
        }
    }
}
