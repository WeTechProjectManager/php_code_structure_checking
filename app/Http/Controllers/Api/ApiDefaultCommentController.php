<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DefaultComment;
use Illuminate\Http\Request;

class ApiDefaultCommentController extends Controller
{

    public function store(Request $request){

        $default_comment = new DefaultComment();

        $default_comment->create($request->except('_token'));

        return response()->json([
            'message' => 'Default comment successfully store',
            'status'  => true
        ],200);

    }
    public function show(){

        $default_comment = DefaultComment::all();
        return response()->json([
            'default_comment' => $default_comment,
            'status' => true,
        ],200);


    }
}
