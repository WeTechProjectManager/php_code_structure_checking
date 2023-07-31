<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\About;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function edit(){
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $about = About::query()->first();
        return view('about.edit',compact('about'));
    }

    public function update(Request $request){
        $about = About::query()->first();
        $data = [
            'title'       => $request->title,
            'description' => $request->description,
        ];
        if($about){
            About::query()->update($data);
        }
        else{
            About::query()->create($data);
        }

        Toastr::success('Success','Success');
        return redirect()->back();
    }

    //about us api

    public function apiAboutUs(){


        $about = About::all();

        if(count($about)!=0){
            return response()->json([
                'about' => $about,
                'status'  => true,
            ],200);
        }
        return response()->json([
            'message' => 'there is no about us information'
        ]);

    }


}
