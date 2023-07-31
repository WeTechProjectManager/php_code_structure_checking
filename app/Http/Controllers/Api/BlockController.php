<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\BlockList;
use App\Models\User;


class BlockController extends Controller
{

    public function block_user(Request $request)
    {
        $validate = $request->validate([
            'block_user_id'                    => 'required',

        ]);

        $user_id = Auth::user()->id;

        $block = new BlockList();
        $block->user_id = $user_id;
        $block->block_user_id = $request->block_user_id;
        $block->status = 'blocked';
        $block->save();

     
        if ($block) {
            return response()->json(['message' => 'User Blocked Successfully'], 200);
        } else {
            return response()->json(['message' => 'Something Went Worng'], 404);
        }
    }
}
