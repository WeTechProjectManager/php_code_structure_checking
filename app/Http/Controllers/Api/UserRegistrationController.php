<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Models\Password;
use App\Models\Referral;
use Illuminate\Support\Str;

class UserRegistrationController extends Controller
{


    public function registration(Request $request)
    {
        $validate = $request->validate([
            'name'                    => 'required',
            'email'                   => 'required',
            'phone'                   => 'required|unique:users',
            'password'                => 'required',
            'address'                 => 'required',
            'birthDate'               => 'required',
        ]);

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $filename = time() . '.' . $photo->getClientOriginalExtension();

            $destinationPath = public_path('assets/user/');
            $photo->move($destinationPath, $filename);
        }

        $marketer_id =  $request->marketer_id;

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->type = 'User';
        $user->status = 'active';
        $user->gender = $request->gender;
        $user->marital_status = $request->marital_status;
        $user->birthDate = $request->birthDate;
        $user->address = $request->address;
        // $user->image = $filename;
        $user->login_status = 'offline';
        $user->password =  Hash::make($request->password);
        $user->save();
        $user['image'] = config('app.url') . '/' . 'assets/user/' . $user['image'];

        $referral = new Referral();
        $referral->user_id =  $user->id;
        $referral->marketer_id = $marketer_id;
        $referral->save();

        $token = Str::random(60);

        if ($user) {
            return response()->json(['message' => 'User saved successfully', 'user_data' => $user,'token'=>$token], 200);
        } else {
            return response()->json(['error' => 'Something Went Worng!'], 401);
        }
    }

    public function loginOrRegister_using_otp(Request $request)
    {
        // Validate the user's phone number
        $request->validate([
            'phone' => 'required|numeric|digits:10'
        ]);

        // Generate a random OTP code
        $otp_code = mt_rand(10000, 99999);

        // Save the OTP code in the database
        $user = User::where('phone', $request->phone)->first();

        if ($user) {
            $user->otp = $otp_code;
            $user->save();
        }


        // Send the OTP code via Fast2SMS API
        $message = urlencode("Thank you for choosing Muslim Matrimony! Your OTP is " . $otp_code);
        $numbers = $request->phone;
        $url = "https://www.fast2sms.com/dev/bulkV2?authorization=YZ8h0BTKoez63tIqPjwVEa5XUWmsxdnCQOkuNM9J7glpDRAbvfIgB4sYDu7jECe6GltkN3hOxfiQpqd2&route=v3&sender_id=FTWSMS&message={$message}&language=english&flash=0&numbers={$numbers}";

        $client = new Client();
        $response = $client->get($url);

        // Return a success response
        return response()->json([
            'message' => 'OTP code sent to your phone number',
            'user_details' => $user,
        ]);
    }
    public function otp_verify(Request $request)
    {
        // Validate the OTP code entered by the user
        $request->validate([
            'phone' => 'required|numeric|regex:/[0-9]{10}/',
            'otp' => 'required|numeric',
        ]);

        // Get the user from the database
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Invalid phone number',
            ], 401);
        }

        // Validate the OTP code
        if ($request->otp != $user->otp) {
            return response()->json([
                'message' => 'Invalid OTP code',
            ], 401);
        }


        // Clear the OTP code from the database
        $user->otp = null;
        $user->save();

        // Return a success response
        return response()->json([
            'message' => 'OTP verification successful',
            'user' => $user,
        ]);
    }

    public function email_verify_using_otp(Request $request)
    {
        $email = $request->email;
        $otp_code = mt_rand(10000, 99999);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->email_otp = $otp_code;
            $user->save();
        }
        /* ------------------------------Mail----------------------------------------*/

        $input['email'] = $email;
        $input['otp'] = $user->email_otp;
        $input['username'] = $user->name;

        Mail::send('mail.email-verify', ['username' => $input['username'], 'email_otp' => $input['otp'],], function ($message) use ($input) {
            $message->from('tithibiswas.dits@gmail.com', '');
            $message->to($input['email']);
            $message->subject('Your One Time Password');
        });


        /* ------------------------------Mail----------------------------------------*/
        // return view('auth.otpverification',compact('email'));
        return response()->json([
            'message' => 'OTP code sent to your Email Id',
            'email' => $email,
        ]);
    }


    public function email_otp_verify(Request $request)
    {
        $user_detail = User::where('email', $request->email)->first();
        if ($user_detail->email_otp == $request->otp) {
            $update_otp_verfied =  User::where('email', $request->email)->limit(1)->update(array('email_verified_at' => Carbon::now(),));

            return response()->json([
                'message' => 'Email Id Successfully Verifie',
                'user_detail' => $user_detail,
            ]);
        } else {
            return response()->json([
                'message' => 'Wrong OTP!',

            ], 404);
        }
    }

    public function forget_password(Request $request)
    {
        $email = $request->email;
        $token =  mt_rand(10000, 99999);

        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        /* ------------------------------Mail----------------------------------------*/

        DB::table('passwords')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        $input['email'] = $email;

        Mail::send('mail.forget-password-verify', ['token' => $token], function ($message) use ($input) {
            $message->from('tithibiswas.dits@gmail.com', '');
            $message->to($input['email']);
            $message->subject('Reset Password Notification');
        });

        /* ------------------------------Mail----------------------------------------*/
        // return view('auth.otpverification',compact('email'));
        return response()->json([
            'message' => 'We have e-mailed your password reset link! :',
            'email' => $email,
        ]);
    }


    public function update_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',

        ]);

        $updatePassword = Password::where(['email' => $request->email, 'token' => $request->token])->first();


        if ($updatePassword) {

            $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
            DB::table('passwords')->where(['email' => $request->email])->delete();
            return response()->json(['message' => 'Your password has been changed! :'], 200);
        } else {

            return response()->json(['error' => 'Invalid token! :'], 404);
        }
    }

    public function sendEmail(Request $request){
        # validation
        $data =  $request->all();
//        $rule=[
//            'email' => 'required',
//        ];
//        $customMessage=[
//            'email.required'        =>  'Email required!',
//            'email.email'           =>  'Email format not valid!',
//        ];
//        $validation=Validator::make($data,$rule,$customMessage);
//        if($validation->fails()){
//            return response()->json($validation->errors(),422);
//        }
        # validation end

        $user = User::query()->where('email',$data['email'])->where('status','active')->first();
        if(!$user)
            return response()->json(['status'=>false,'message'=>'Email not found!']);

        $otp_code = mt_rand(10000, 99999);
        $user->update(['otp'=>$otp_code]);

        $data=['name'=>$user->name ?? "", 'bodyData'=>"Your OTP: $otp_code Thanks for using our application"];
        Mail::send('mail',$data,function ($msg) use ($user){
            $msg->to($user->email);
            $msg->subject('Matrimony Application');
        });

        return response()->json(['status'=>true,'message'=>'Otp send successfully'],200);

    }

    public function otpMatch(Request $request){
        $data =  $request->all();

        $user = User::query()->where('email',$data['email'])->where('otp',$data['otp'])->where('status','active')->first();
        if(!$user)
            return response()->json(['status'=>false,'message'=>'Wrong OTP!'],404);
        else
            return response()->json(['status'=>true,'message'=>'Otp match successfully'],200);

    }

    public function passwordUpdate(Request $request){
        $data =  $request->all();
        User::query()->where('email',$data['email'])
            ->update(['password' => Hash::make($data['password']),'otp'=>0]);
        return response()->json(['status'=>true,'message'=>'Password changed successfully'],200);
    }

}
