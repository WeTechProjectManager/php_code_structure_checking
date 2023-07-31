<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class ApiPostCommentController extends Controller
{

   public function store(Request $request){

        $usercomment = PostComment::where('post_id', $request->post_id)
                       ->where('user_id', Auth::user()->id)->get();
        $user = User::find(Auth::user()->id);

        if(count($usercomment)==0 && $user->type == 'User' && $user->status == 'active'){
            $postcomment = new PostComment();

            $postcomment->user_id = Auth::user()->id;
            $postcomment->post_id = $request->post_id;
            $postcomment->defaultcomment_id = $request->defaultcomment_id;
            $postcomment->save();


        #save notification
    $user_details = User::where('id', $postcomment->user_id)->first();

    $post_details = Post::where('id', $postcomment->post_id)->first();

    $post_user_details = User::where('id',$post_details->user_id)->first();

    $name = $user_details->name;
    $msg = "Commented on";
    $comment_user_name = $post_user_details->name;
    $msgs = "'s post";

    $message = $comment_user_name . " " . $msg." ".$name." ".$msgs;

    $notification = new Notification();
    $notification->message = $message;
    $notification->date = date('Y-m-d');
    $notification->created_by = $request->user_id;
    $notification->read_by = '';
    $notification->save();
            // $postcomment->create($request->except('_token'));
            return response()->json([
                'message' => 'Comment successfully upload',
                'status'  => true
            ],200);
        }

        else{
            return response()->json([
                'error' => 'there ar something error!',
            ]);
        }

    }


    public function show($post_id){

        $postComments = PostComment::where('post_id', $post_id)
                        ->with('getPostCommentUserName')
                        ->with('getPostComment')
                        ->get();
        // dd($postComments);
        $commentWithuser = [];
        foreach($postComments as $postComment){
            $user = $postComment->getPostCommentUserName;
            // Assuming the 'name' field contains the user's name, modify accordingly if needed
            $userName = $user->name;
            $userProfile = 'https://muslimmatrimonywell.com' . '/' . 'public/assets/user/'.  $user->image ?? '';
            $userlogin_status = $user->login_status;

            $postComment->unsetRelation('getPostCommentUserName');
            $postComment->username = $userName;
            $postComment->userprofile = $userProfile;
            $postComment->userlogin_status = $userlogin_status;

            $defaultComment = $postComment->getPostComment;
            $comment = $defaultComment->comment;
            $postComment->unsetRelation('getPostComment');
            $postComment->comment_text = $comment;
            $commentWithuser[] = $postComment;

        }

        return response()->json([
            'postcomment' => $commentWithuser,
            'status' => true,
        ],200);

    }



    public function isComment(Request $request){

        $iscomment = PostComment::where('post_id',$request->post_id)
                    ->where('user_id', Auth::user()->id)
                    ->get();
        //  dd($iscomment);
        if(count($iscomment)==0){
             return response()->json([
                'iscomment' => false,
                'status' => true,
            ],200);
        }

         else{
            return response()->json([
                'iscomment' => true,
                'status' => true,
            ],200);

        }
    }
}
