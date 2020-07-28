<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use JWTAuth;
use Validator;
use Mail;
use App\User;


class LoginController extends Controller
{
    public function login(Request $request){
        // return $request->all();
        $creds = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];
        // return $creds;

        // $token = JWTAuth::attempt($creds, $rememeber = true);
        if(!$token = JWTAuth::attempt($creds)){
            return apiReturn($creds, 'Incorrect Email/Password', 'failed');
        }

        $user = auth()->user();
        $user['jwt_token'] = $token;
        $user['role'] = auth()->user()->role;

        return apiReturn($user);
    }
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function refresh(){
        try {

            $newToken = JWTAuth::refresh();
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return response()->json(['token' => $newToken]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function checkForgotPassword($token){

        $user = User::where('reset_token', $token)->first();
        if(empty($user)){
            return apiReturn([$token], 'Invalid Token', 'failed');
        }
        return apiReturn($token);
    }

    public function forgotPassword(Request $request){

        // Validate Request
        $v = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if ($v->fails()) return apiReturn($request->all(), 'Validation Failed', 'failed', [$v->errors()]);

        // Set Variables
        $token = Str::random(30); // Generate random 30 characters
        $expire_on = 30;
        $expire_reset_token = Carbon::now()->addMinutes($expire_on); // Add 30 minutes

        // Get User and insert reset_token and expire_reset_token
        $user = User::where('email', $request->email)->first();
        $user['reset_token'] = $token;
        $user['expire_reset_token'] = $expire_reset_token;
        $user->update();

        // Set Params
        $params = [
            'name' => $user->name,
            'email' => $request->email,
            'token' => $token,
            'expire_reset_token' => $expire_reset_token,
        ];
        $to = $request->email; // Get user email

        // Send Email
        Mail::send('mail.forgot-password', $params, function ($m) use($request, $to) {
            $m->subject('Reset Password');
            $m->to($to);
        });

        return apiReturn($request->all(), 'Success');
    }

    public function resetPassword($token, Request $request) {

        // Validate Request
        $v = Validator::make($request->all(), [
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6',
        ]);
        if ($v->fails()) return apiReturn($request->all(), 'Validation Failed', 'failed', [$v->errors()]);

        // Valdiate Token
        $user = User::where('reset_token', $token)->first();
        if(empty($user)){
            return apiReturn($request->all(), 'Invalid Token', 'failed');
        }

        // Check expire reset token time
        if(Carbon::parse($user->expire_reset_token) < Carbon::now()){
            return apiReturn($request->all(), 'The token was already expired.', 'failed');
        }

        // Validate Password
        $valiations = loginValidateResetPassword($request->all(), $user);
        if ($valiations) return apiReturn($request->all(), 'Validation Failed', 'failed', [$valiations]);

        // Set updates
        $user['password'] = bcrypt($request->confirm_password);
        $user['default_password'] = 1;
        $user['reset_token'] = null;
        $user['expire_reset_token'] = null;

        // Update user password and remove reset_token and expire_reset_token
        if($user->update()){
            return apiReturn($request->all(), 'Successfully reset the password');
        } else {
            return apiReturn($request->all(), 'Cannot reset password', 'failed');
        }


    }

    function newPassword(Request $request){

        // Validate Request
        $v = Validator::make($request->all(), [
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6',
        ]);
        if ($v->fails()) return apiReturn($request->all(), 'Validation Failed', 'failed', [$v->errors()]);

        // Get Logged User
        $user = auth()->user();

        // Check if user already updated the default password
        if($user['default_password'] == 1) return apiReturn($request->all(), 'This user already changed the default password.', 'failed');

        // Validate Password
        $valiations = loginValidateResetPassword($request->all(), $user);
        if ($valiations) return apiReturn($request->all(), 'Validation Failed', 'failed', [$valiations]);

        $user = User::where('id', $user['id'])->first();
        $user['password'] = bcrypt($request->confirm_password);
        $user['default_password'] = 1;

        if($user->update()){
            return apiReturn($user, 'Successfully reset the password');
        } else {
            return apiReturn($request->all(), 'Cannot reset password', 'failed');
        }
    }
}
