<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DefaultComment;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DefaultCommentController extends Controller
{
    public function index(Request $request)
    {
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $defaultComment = DefaultComment::query()->get();
        return view('defaultComment.index',compact('defaultComment'));
    }

    public function store(Request $request){

        DefaultComment::query()->insert([
            'comment'       => $request->comment,
            'created_at'    => Carbon::now(),
        ]);

        Toastr::success('Data added successfully','Success');
        return redirect()->back();
    }

    public function update(Request $request){

        $update = [
            'comment'       => $request->comment,
            'updated_at'    => Carbon::now(),
        ];
        DefaultComment::query()->where('id',$request->id)->update($update);

        Toastr::success('Update successfully','Success');
        return redirect()->back();
    }
}
