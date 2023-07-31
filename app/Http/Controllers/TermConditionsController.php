<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TermConditions;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TermConditionsController extends Controller
{
    public function edit(){
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $termsConditions = TermConditions::query()->first();
        return view('termCondition.edit',compact('termsConditions'));
    }

    public function update(Request $request){
        $termsConditions = TermConditions::query()->first();
        $data = [
            'title'       => $request->title,
            'description' => $request->description,
        ];
        if($termsConditions){
            TermConditions::query()->update($data);
        }
        else{
            TermConditions::query()->create($data);
        }

        Toastr::success('Success','Success');
        return redirect()->back();
    }


    //api termsConditions

    public function apiTermsConditions(){


        $termsConditions = TermConditions::all();

        if(count($termsConditions)!=0){
            return response()->json([
                'termsConditions' => $termsConditions,
                'status'  => true,
            ],200);
        }
        return response()->json([
            'message' => 'there is no Terms of Conditions'
        ]);

    }
}
