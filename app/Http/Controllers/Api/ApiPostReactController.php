<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PostReact;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiPostReactController extends Controller
{

    public function store(Request $request){

        $store_react = PostReact::where('post_id', $request->post_id)
                       ->where('user_id', Auth::user()->id)
                       ->get();


        if(count($store_react) == 0){

            $post = Post::find($request->post_id);
            $post->view = $post->view + 1;
            $post->save();
            $create_post_react = new PostReact();
            $create_post_react->user_id =  Auth::user()->id;
            $create_post_react->post_id = $request->post_id;
            $create_post_react->react = '1';
            $create_post_react->save();


            return response()->json([
                'message' => 'React successfully Done',
                'status'  => true
            ],200);

        }


        else{
            return response()->json(['error'=>'Something Error']);
        }

    }

    public function remove(Request $request){

        $remove_react = PostReact::where('post_id', $request->post_id)
                           ->where('user_id',  Auth::user()->id)->get();


        if(count($remove_react) != 0){

            PostReact::where('post_id', $request->post_id)
                           ->where('user_id',  Auth::user()->id)
                           ->delete();

            return response()->json([
                'message' => 'React successfully Remove',
                'status'  => true
            ],200);

        }

        else{
            return response()->json(['error'=>'Something Error']);
        }

    }



    public function isReact(Request $request){

        $isreact = PostReact::where('post_id',$request->post_id)
                    ->where('user_id', Auth::user()->id)
                    ->get();
        //  dd($isreact);
        if(count($isreact)==0){
             return response()->json([
                'isreact' => false,
                'status' => true,
            ],200);
        }

        else{
            return response()->json([
                'isreact' => true,
                'status' => true,
            ],200);

        }
    }
   public function showEveryPostReact(Request $request) {
        $postReacts = PostReact::where('post_id', $request->post_id)
                               ->with('getPostReactUserName')
                               ->get();

        $postReactsWithUserNames = [];
        foreach ($postReacts as $postReact) {
            $user = $postReact->getPostReactUserName;
            // Assuming the 'name' field contains the user's name, modify accordingly if needed
            $userName = $user->name;

            $userProfile = 'https://muslimmatrimonywell.com' . '/' . 'public/assets/user/'.  $user->image ?? '';

            // Modify the postReact object to include only the user name
            $postReact->unsetRelation('getPostReactUserName');
            $postReact->user_name = $userName;
            $postReact->profile = $userProfile;

            $postReactsWithUserNames[] = $postReact;
        }

        return response()->json([
            'postReacts' => $postReactsWithUserNames,
            'status' => true,
        ], 200);
    }



}
