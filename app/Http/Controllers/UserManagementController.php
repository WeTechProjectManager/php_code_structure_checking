<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $name = $request->name;
        $status = $request->status;
        $email = $request->email;
        $phone = $request->phone;
        $gender = $request->gender;
        //$realFake_status = $request->realFake_status;
        $login_status = $request->login_status;
        $result = User::query()
            ->where(function ($q) use($name,$status,$email,$phone,$gender,$login_status){
                if($name)
                    $q->where('name','LIKE','%'.$name.'%');
                if($status)
                    $q->where('status',$status);
                if($email)
                    $q->where('email',$email);
                if($phone)
                    $q->where('phone',$phone);
                if($gender)
                    $q->where('gender',$gender);
                if($login_status)
                    $q->where('login_status',$login_status);
            })
            ->where('realFake_status','real')
            ->where('type','User')
            ->simplePaginate(20);

        # total count on search
        $total = User::query()
            ->where(function ($q) use($name,$status,$email,$phone,$gender,$login_status){
                if($name)
                    $q->where('name','LIKE','%'.$name.'%');
                if($status)
                    $q->where('status',$status);
                if($email)
                    $q->where('email',$email);
                if($phone)
                    $q->where('phone',$phone);
                if($gender)
                    $q->where('gender',$gender);
                if($login_status)
                    $q->where('login_status',$login_status);
            })
            ->where('realFake_status','real')
            ->where('type','User')
            ->count();

        return view('usermanagement.user_control',compact('result','total'));
    }

    # search user
    public function searchUser(Request $request)
    {
            $users      = DB::table('users')->where('type','!=','Admin')->simplePaginate(20);
            $result     = DB::table('users')->where('type','!=','Admin')->simplePaginate(20);

            // search by name
            if($request->name)
            {
                $result = User::where('name','LIKE','%'.$request->name.'%')->simplePaginate(20);
            }

            // search by role name
            if($request->role_name)
            {
                $result = User::where('type','LIKE','%'.$request->role_name.'%')->simplePaginate(20);
            }

            // search by status
            if($request->status)
            {
                $result = User::where('status','LIKE','%'.$request->status.'%')->simplePaginate(20);
            }

            // search by name and role name
            if($request->name && $request->role_name)
            {
                $result = User::where('name','LIKE','%'.$request->name.'%')
                                ->where('type','LIKE','%'.$request->role_name.'%')
                                ->simplePaginate(20);
            }

            // search by role name and status
            if($request->role_name && $request->status)
            {
                $result = User::where('type','LIKE','%'.$request->role_name.'%')
                                ->where('status','LIKE','%'.$request->status.'%')
                                ->simplePaginate(20);
            }

            // search by name and status
            if($request->name && $request->status)
            {
                $result = User::where('name','LIKE','%'.$request->name.'%')
                                ->where('status','LIKE','%'.$request->status.'%')
                                ->simplePaginate(20);
            }

            // search by name and role name and status
            if($request->name && $request->role_name && $request->status)
            {
                $result = User::where('name','LIKE','%'.$request->name.'%')
                                ->where('type','LIKE','%'.$request->role_name.'%')
                                ->where('status','LIKE','%'.$request->status.'%')
                                ->simplePaginate(20);
            }

            return view('usermanagement.user_control',compact('users','result'));


    }


    // save new user
    public function addNewUserSave(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            //'phone'     => 'required|min:11|numeric',
            'role_name'       => 'required|string|max:255',
            'status'          => 'required|string|max:255',
            'realFake_status' => 'required',
            'gender'          => 'required',
            //'image'     => 'required|image',
            'password'        => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ],
            [
                'name.required'         =>  'Name required!',
                'email.required'        =>  'Email required!',
                'email.email'           =>  'Email format not valid!',
                'email.unique'          =>  'Email exist!',
                'role_name.required'    =>  'Role Name required!',
                'status.required'       =>  'Status required!',
                'realFake_status.required' =>  'Real/Fake status required!',
                'gender.required'       =>  'Gender required!',
                'password.required'     =>  'Password required!',
                'password.min'          =>  'Password Minimum 6 character required!',
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
            $user->realFake_status = $request->realFake_status;
            $user->gender       = $request->gender;
            $user->login_status = $login_status;
            //$user->avatar       = $image;
            $user->password     = Hash::make($request->password);
            $user->save();
            DB::commit();
            Toastr::success('Create new account successfully :)','Success');
            return redirect()->route('userManagement');
        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User add new account fail :)','Error');
            return redirect()->back();
        }
    }

    // update
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
            Toastr::success('User updated successfully :)','Success');
            return redirect()->route('userManagement');

        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User update fail :)','Error');
            return redirect()->back();
        }
    }

    // delete
    public function delete(Request $request)
    {
        $user = Auth::User();
        Session::put('user', $user);
        $user=Session::get('user');
        DB::beginTransaction();
        try{
            $fullName     = $user->name;
            $email        = $user->email;
            $phone        = $user->phone;
            $status       = $user->status;
            $role_name    = $user->role_name;

            if($request->avatar =='photo_defaults.jpg'){
                User::destroy($request->id);
            }else{
                User::destroy($request->id);
                unlink('assets/images/'.$request->avatar);
            }
            DB::commit();
            Toastr::success('User deleted successfully :)','Success');
            return redirect()->route('userManagement');

        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('User deleted fail :)','Error');
            return redirect()->back();
        }
    }

    // view change password
    public function changePasswordView()
    {
        return view('settings.changepassword');
    }

    // change password in db
    public function changePasswordDB(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        DB::commit();
        Toastr::success('User change successfully :)','Success');
        return redirect()->intended('home');
    }

    public function analytics(){
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $data['totalUser'] = User::query()->where('type','User')->count();
        $data['active'] = User::query()->where('type','User')->where('status','active')->count();
        $data['inactive'] = User::query()->where('type','User')->where('status','inactive')->count();
        $data['delete'] = User::query()->where('type','User')->where('status','delete')->count();

        $data['online'] = User::query()->where('type','User')->where('login_status','online')->count();
        $data['offline'] = User::query()->where('type','User')->where('login_status','offline')->count();

        $data['real'] = User::query()->where('type','User')->where('realFake_status','real')->count();
        $data['fake'] = User::query()->where('type','User')->where('realFake_status','fake')->count();

        $data['new'] = User::query()->where('type','User')->whereDate('created_at',Carbon::today())->count();

        return view('usermanagement.user_analytics',compact('data'));
    }

    public function profile($id){
        $user = User::query()->findOrFail($id);
        $posts = Post::query()->where('user_id',$id)->orderBy('id','desc')->get();
        return view('usermanagement.profile',compact('user','posts'));
    }

    /**
     * fakeUser
     */
    public function fakeUser(Request $request)
    {
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $name = $request->name;
        $status = $request->status;
        $email = $request->email;
        $phone = $request->phone;
        $gender = $request->gender;
        //$realFake_status = $request->realFake_status;
        $login_status = $request->login_status;
        $result = User::query()
            ->where(function ($q) use($name,$status,$email,$phone,$gender,$login_status){
                if($name)
                    $q->where('name','LIKE','%'.$name.'%');
                if($status)
                    $q->where('status',$status);
                if($email)
                    $q->where('email',$email);
                if($phone)
                    $q->where('phone',$phone);
                if($gender)
                    $q->where('gender',$gender);
                if($login_status)
                    $q->where('login_status',$login_status);
            })
            ->where('realFake_status','fake')
            ->where('type','User')
            ->simplePaginate(20);

        # total count on search
        $total = User::query()
            ->where(function ($q) use($name,$status,$email,$phone,$gender,$login_status){
                if($name)
                    $q->where('name','LIKE','%'.$name.'%');
                if($status)
                    $q->where('status',$status);
                if($email)
                    $q->where('email',$email);
                if($phone)
                    $q->where('phone',$phone);
                if($gender)
                    $q->where('gender',$gender);
                if($login_status)
                    $q->where('login_status',$login_status);
            })
            ->where('realFake_status','fake')
            ->where('type','User')
            ->count();

        return view('usermanagement.fakeUser',compact('result','total'));
    }

}









