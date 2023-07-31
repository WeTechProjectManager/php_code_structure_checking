<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    //password reset

    public function resetPassword(Request $request){

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required'],
            'new_confirm_password' => 'required|same:new_password',
        ]);

        $user = User::find($request->user_id);
        if(!Hash::check($request->current_password , $user->password)){
            return response()->json([
                'message' => 'Old password does not match !'
            ],201);
        }
        else{
            $user->update(['password' => Hash::make($request->new_password)]);
            return response()->json([
                'success' => 'Your password successfully changed'
            ]);
        }

    }

    //email reset
    public function resetEmail(Request $request){

        $request->validate([
            'current_password' => ['required'],
            'email' => 'required|email|unique:users,email,'.$request->user_id,
        ]);

        $user = User::find($request->user_id);
        if(!Hash::check($request->current_password , $user->password)){
            return response()->json([
                'message' => 'Old password does not match !'
            ],201);
        }
        else{
            $user->update(['email' => $request->email]);
            return response()->json([
                'success' => 'Your email successfully changed'
            ]);
        }
    }

    //paaword amd email reset
    public function resetEmailPassword(Request $request){

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required'],
            'new_confirm_password' => 'required|same:new_password',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
        ]);

        $user = User::find($request->user_id);
        if(!Hash::check($request->current_password , $user->password)){
            return response()->json([
                'message' => 'Old password does not match !'
            ],201);
        }
        else{
            $user->update([
                'email' => $request->email,
                'password' => Hash::make($request->new_password),

            ]);
            return response()->json([
                'success' => 'Your email & password successfully changed'
            ]);
        }
    }


}
