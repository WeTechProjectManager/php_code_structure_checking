<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MarketerController extends Controller
{
    public function index(Request $request)
    {
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $email = $request->email;
        $marketers = User::query()
            ->where(function ($q) use ($email){
                if($email)
                    $q->where('email',$email);
            })
            ->where('type','Marketer')
            ->simplePaginate(20);
        return view('marketer.index',compact('marketers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            //'phone'     => 'required|min:11|numeric',
            'role_name'       => 'required',
            'status'          => 'required',
            'gender'          => 'required',
            //'image'     => 'required|image',
            'password'        => 'required|string|min:5|confirmed',
            'password_confirmation' => 'required',
        ],
            [
                'name.required'         =>  'Name required!',
                'email.required'        =>  'Email required!',
                'email.email'           =>  'Email format not valid!',
                'email.unique'          =>  'Email exist!',
                'role_name.required'    =>  'Type required!',
                'status.required'       =>  'Status required!',
                'gender.required'       =>  'Gender required!',
                'password.required'     =>  'Password required!',
                'password_confirmation.required'     =>  'Repeat password required!',
                'password.confirmed'    =>  'Password not match!',
            ]
        );

        DB::beginTransaction();
        try{

//            if (!empty($request->image))
//            {
//                $image = time().'.'.$request->image->extension();
//                $request->image->move(public_path('assets/images'), $image);
//            }
//            else
//                $image='';

            $login_status = 'offline';
            if($request->realFake_status == 'fake')
                $login_status = 'online';

            $user = new User;
            $user->name         = $request->name;
            $user->email        = $request->email;
            $user->phone        = $request->phone;
            $user->type         = $request->role_name;
            $user->status       = $request->status;
            $user->realFake_status = 'real';
            $user->gender       = $request->gender;
            $user->login_status = 'offline';
            //$user->avatar       = $image;
            $user->password     = Hash::make($request->password);
            $user->save();

            DB::commit();
            Toastr::success('Marketer account create successfully','Success');
            return redirect()->back();

        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Fail!','Error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try{
            $name         = $request->name;
            $email        = $request->email;
            $role_name    = $request->role_name;
            $phone        = $request->phone;
            $status       = $request->status;

            //$dt       = Carbon::now();
            //$todayDate = $dt->toDayDateTimeString();
//            $image_name = $request->hidden_image;
//            $image = $request->file('images');
//            if($image_name =='photo_defaults.jpg')
//            {
//                if($image != '')
//                {
//                    $image_name = rand() . '.' . $image->getClientOriginalExtension();
//                    $image->move(public_path('/assets/images/'), $image_name);
//                }
//            }
//            else{
//
//                if($image != '')
//                {
//                    $image_name = rand() . '.' . $image->getClientOriginalExtension();
//                    $image->move(public_path('/assets/images/'), $image_name);
//                }
//            }

            $update = [
                'name'    => $name,
                'type'    => $role_name,
                'email'   => $email,
                'phone'   => $phone,
                'status'  => $status,
                //'avatar'  => $image_name,
            ];

            # password
            if($request->password){
                $update = [
                    'name'    => $name,
                    'type'    => $role_name,
                    'email'   => $email,
                    'phone'   => $phone,
                    'status'  => $status,
                    'password'=> Hash::make($request->password)
                ];
            }

            User::where('id',$request->id)->update($update);

            DB::commit();
            Toastr::success('Updated successfully :)','Success');
            return redirect()->back();

        }
        catch(\Exception $e){
            DB::rollback();
            Toastr::error('Update fail :)','Error');
            return redirect()->back();
        }
    }
}
