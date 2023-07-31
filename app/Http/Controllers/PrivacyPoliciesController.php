<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicies;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivacyPoliciesController extends Controller
{
    public function edit(){
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $privacyPolicy = PrivacyPolicies::query()->first();
        return view('privacyPolicy.edit',compact('privacyPolicy'));
    }

    public function update(Request $request){
        $privacyPolicy = PrivacyPolicies::query()->first();
        $data = [
            'title'       => $request->title,
            'description' => $request->description,
        ];
        if($privacyPolicy){
            PrivacyPolicies::query()->update($data);
        }
        else{
            PrivacyPolicies::query()->create($data);
        }

        Toastr::success('Success','Success');
        return redirect()->back();
    }

      //api privacyPolicies

      public function apiPrivacyPolicies(){


        $privacyPolicies = PrivacyPolicies::all();

        if(count($privacyPolicies)!=0){
            return response()->json([
                'privacyPolicies' => $privacyPolicies,
                'status'  => true,
            ],200);
        }
        return response()->json([
            'message' => 'there is no Privacy and Policies'
        ]);

    }

}
