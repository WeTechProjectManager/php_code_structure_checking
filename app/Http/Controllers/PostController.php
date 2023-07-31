<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\IncreaseView;
use App\Models\Post;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request){
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $posts = Post::query()->orderBy('id','desc')->simplePaginate(20);
        return view('post.index',compact('posts'));
    }

    public function increaseViewSetup(Request $request){
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $datas = IncreaseView::query()->get();
        return view('post.increaseViewSetup',compact('datas'));
    }

    public function store_increaseViewSetup(Request $request){

        IncreaseView::query()->insert([
            'from'  => $request->from,
            'to'    => $request->to,
            'view'  => $request->view,
            'created_at'  => Carbon::now(),
        ]);

        Toastr::success('Success','Success');
        return redirect()->back();
    }

    public function update_increaseViewSetup(Request $request){

        IncreaseView::query()->where('id',$request->id)->update([
            'from'  => $request->from,
            'to'    => $request->to,
            'view'  => $request->view,
            'updated_at'  => Carbon::now(),
        ]);

        Toastr::success('Success','Success');
        return redirect()->back();
    }

}
