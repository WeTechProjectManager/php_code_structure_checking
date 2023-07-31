<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\QuestionAndAns;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpSupportController extends Controller
{
    public function index(Request $request)
    {
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $questionAns = QuestionAndAns::query()->get();

        return view('helpAndSupport.index',compact('questionAns'));
    }

    public function store(Request $request)
    {
        QuestionAndAns::query()->insert([
            'questions'     => $request->questions,
            'ans'           => $request->ans,
            'created_at'    => Carbon::now(),
        ]);

        Toastr::success('Data added successfully','Success');
        return redirect()->back();
    }

    public function update(Request $request){

        $update = [
            'questions'     => $request->questions,
            'ans'           => $request->ans,
            'updated_at'    => Carbon::now(),
        ];
        QuestionAndAns::query()->where('id',$request->id)->update($update);

        Toastr::success('Update successfully','Success');
        return redirect()->back();
    }

}
