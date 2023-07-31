<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:5|confirmed',
            'password_confirmation' => 'required',

        ]);

        # user registration
        User::create([
            'name'      => $request->name,
            //'image'    => $request->image,
            'email'     => $request->email,
            'type'      => 'Admin',
            'password'  => Hash::make($request->password),
            'created_at' => date("Y-m-d H:i:s")
        ]);

        Toastr::success('Create new account successfully :)','Success');
        return redirect('login');

    }
}
