<?php
// use Hash;
use Carbon\Carbon;

function loginValidateResetPassword($request, $user){
    // return $user;

    $errors = [];
    // Check Old Password
    // if(!Hash::check($request['old_password'], $user['password'])){
    //     $errors[] = "Incorrect old password.";
    // }

    // Validate new password and confirm password
    if($request['new_password'] != $request['confirm_password']) {
        $errors[] = "New password and confirm password doesn't match.";
    }
    return $errors;
}
