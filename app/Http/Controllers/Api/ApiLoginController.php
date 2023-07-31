<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;



class ApiLoginController extends Controller
{
    /**
     * Login api
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $currentDateTime = \Carbon\Carbon::now();
            $now_time =  $currentDateTime->format('Y-m-d H:i:s');

            $Login = User::where('id', $user->id)->update(['login_status' => 'online', 'updated_at' => $now_time]);

            $access_token =  $user->createToken($user->name)->plainTextToken;

            return response()->json([
                'access_token' => $access_token,
                'user'         => [
                    'user_id' => $user->id,
                    'name'    => $user->name,
                    'email'   => $user->email,
                    'type'    => $user->type,
                    'status'  => $user->status,
                ],
                'message'      => "User login successfully",
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $currentDateTime = \Carbon\Carbon::now();
        $now_time = $currentDateTime->format('Y-m-d H:i:s');
        $Login = User::where('id', $user->id)->update(['login_status' => 'offline', 'updated_at' => $now_time]);

        auth()->user()->tokens()->delete();

        return response()
            ->json(['status' => true, 'message' => 'Logged out successfully'], 200);
    }

    /**
     * @return JsonResponse
     */
    public function profile(): JsonResponse
    {
        $user = Auth::user();

        $userInfo = [
            'user_id' => $user->id,
            'name'   => $user->name,
            'short_bio'   => $user->short_bio,
            'hightEducationGeneral'  => $user->getUserBioData->getUserBioDataHightEducationGeneral->hightEducationGeneral ?? '',
            'partnerEducationIslamic'  => $user->getUserBioData->getUserBioDataHightEducationIslamic->partnerEducationIslamic ?? '',
            'insituteName'  => $user->getUserBioData->insituteName ?? '',
            'address'  => $user->address,
            'gender'  => $user->gender,
            'country'  => $user->getUserBioData->getUserBioDataCountry->country ?? '',
            'marital_status'  => $user->marital_status,
            'profile_status' =>  $user->image_status,

        ];
        return response()->json($userInfo, 200);
    }
    public function showOtherProfile(Request $request): JsonResponse
    {
        $user = User::find($request->user_id);

        $userInfo = [
            'user_id' =>$user->id,
            'name'   => $user->name,
            'profile_pic' => 'https://muslimmatrimonywell.com' . '/' . 'public/assets/user/'.  $user->image,
            'cover_pic' => 'https://muslimmatrimonywell.com' . '/' . 'public/assets/user/cover/'.  $user->cover_pic,
            'hightEducationGeneral'  => $user->getUserBioData->getUserBioDataHightEducationGeneral->hightEducationGeneral ?? '',
            'partnerEducationIslamic'  => $user->getUserBioData->getUserBioDataHightEducationIslamic->partnerEducationIslamic ?? '',
            'insituteName'  => $user->getUserBioData->insituteName ?? '',
            'address'  => $user->address,
            'login_status'  => $user->login_status,
            'gender'  => $user->gender,
            'country'  => $user->getUserBioData->getUserBioDataCountry->country ?? '',
            'marital_status'  => $user->marital_status,
            'profile_status' =>  $user->image_status,

        ];
        return response()->json([
            'userInfo' => $userInfo,

            ], 200);
    }
}
