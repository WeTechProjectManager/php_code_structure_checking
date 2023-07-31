<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBioData;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    public function userSearchByName(Request $request){

        $name = $request['name'] ?? '';

        if($name != ''){
            $searchs = User::where('name', 'LIKE', "%$name%")
                        ->where('type' ,"=", 'User')
                        ->where('status',"=",'active')->take(40)->get();
            if(count($searchs) != 0){

                foreach ($searchs  as $key => $search) {

                    if ($search->image != null || $search->image != '') {
                        $searchs[$key]['image'] = config('app.url') . '/' . 'asset/user/'. $search->image;
                    } else {
                        $searchs[$key]['image'] = '';
                    }

                }

                return response()->json([
                    'searchresult' => $searchs,
                    'status' => true,
                ],200);
            }
            else{
                return response()->json([
                    'searchresult' => 'No Result Found',
                    'status' => true,
                ],200);
            }
        }
    }


    public function allsearch(Request $request){

        $name = $request['name'] ?? '';
        $email = $request['email'] ?? '';
        $phone = $request['phone'] ?? '';
        $gender = $request['gender'] ?? '';
        $birthyear = $request['birthyear'] ?? '';
        $marital_status = $request['marital_status'] ?? '';
        $fullName = $request['fullName'] ?? '';
        $min_height = $request['min_height'] ?? '';
        $max_height = $request['max_height'] ?? '';
        $min_weight = $request['min_weight'] ?? '';
        $max_weight = $request['max_weight'] ?? '';
        $jobTitle = $request['jobTitle'] ?? '';
        $bodyType = $request['bodyType'] ?? '';
        $hairColor = $request['hairColor'] ?? '';
        $eyeColor = $request['eyeColor'] ?? '';
        $bodycolor = $request['bodycolor'] ?? '';
        $hightEducationGeneral = $request['hightEducationGeneral'] ?? '';
        $hightEducationIslamic = $request['hightEducationIslamic'] ?? '';



       if($name != '' || $email != '' ||$phone != '' || $gender != '' || $birthyear != '' ||$fullName != '' || $max_height != '' || $min_height != '' || $min_weight != '' || $max_weight !='' || $jobTitle != '' || $bodyType != '' || $hairColor != '' || $eyeColor != ''|| $bodycolor != '' ||$hightEducationGeneral != '' || $hightEducationIslamic != '' ){

            $users = User::where(function($query) use ($name, $email,$phone, $gender,$birthyear,  $marital_status ){
                $query->where('name' , 'LIKE', "$name")
                ->orWhere('email', 'LIKE', "$email")
                ->where('phone', 'LIKE', "$phone")
                ->orWhere('gender' , 'LIKE', "$gender")
                ->orWhere('birthDate', 'LIKE', "$birthyear")
                ->orWhere('marital_status', 'LIKE', "$marital_status")
                ->where('status', '=', 'active')
                ->where('type', '=', 'User');
            })->orwhereHas('getUserBioData',function($query) use($fullName, $min_height, $max_height ,$max_weight, $min_weight,$jobTitle,$bodyType, $hairColor, $eyeColor,$bodycolor, $hightEducationGeneral, $hightEducationIslamic){
                $query->where('fullName', 'LIKE' ,"$fullName")
                ->whereBetween('height', [$min_height, $max_height])
                ->whereBetween('weight', [$min_weight, $max_weight])
                ->orWhere('jobTitle', 'LIKE', "$jobTitle")
                ->orWhere('bodyType', 'LIKE', "$bodyType")
                ->orWhere('hairColor', 'LIKE', "$hairColor")
                ->orWhere('eyeColor', 'LIKE', "$eyeColor")
                ->orWhere('bodycolor', 'LIKE', "$bodycolor")
                ->orWhere('hightEducationGeneral', 'LIKE', "$hightEducationGeneral")
                ->orWhere('hightEducationIslamic', 'LIKE', "$hightEducationIslamic");
            })->get();

            foreach ($users  as $key => $user) {

                if ($user->image != null || $user->image != '') {
                    $users[$key]['image'] = config('app.url') . '/' . 'asset/user/'. $user->image;
                } else {
                    $users[$key]['image'] = '';
                }

            }

            return response()->json([
                'feilter' => $users,
                'status'  => true
            ],200);

       }

       else{
            return response()->json([
                'message' => 'Please give parameter',
                'status'  => true
            ],200);

       }
    }
}
