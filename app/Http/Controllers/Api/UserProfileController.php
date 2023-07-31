<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostReact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{

    public function uploadProfile(Request $request){

        $request->validate([
            'image' => 'required|image'
        ]);

        $user_profile_upload = User::find($request->user_id);

        if($user_profile_upload->type =='User' && $user_profile_upload->status == 'active'){

            if($request->image != ''){
                $image = $request->image;
                $filename =$request->user_id . rand(). '.'. $image->getClientOriginalExtension();
                $location = public_path('assets/user/');
                $image->move($location, $filename);
                $user_profile_upload->image = $filename;

            }
            $user_profile_upload->save();

            return response()->json([
                'message' => 'Profile successfully updated',
                'status'  => true
            ],200);

        }

        else{
            return response()->json(['error'=>'Something error']);
        }


    }

    public function profileDetailsUpdate(Request $request){

        // $request->validate([
        //     'name' => 'required',
        //     'phone' => 'required',
        //     'address' => 'required',
        //     'birthDate' => 'required|date',
        //     'gender' => 'required',
        //     'marital_status' => 'required'
        // ]);

        $user_profile_details = User::find($request->user_id);

        if($user_profile_details->type =='User' && $user_profile_details->status == 'active'){
            $user_profile_details->update($request->except('_token')+ $request->except('user_id')+['updated_at' => Carbon::now()]);
            return response()->json([
                'message' => 'Profile deatils successfully updated',
                'status'  => true
            ],200);
        }
    }


    public function profilePic(Request $request){

        $profile = User::find($request->user_id);

        $profile_pic = 'https://muslimmatrimonywell.com' . '/' . 'public/assets/user/'.  $profile->image;

        return response()->json([
            'profile_pic' => $profile_pic,
            'status'  => true
        ],200);

    }


    public function uploadCover(Request $request){

        $request->validate([
            'cover_pic' => 'image'
        ]);

        $user_cover_pic_upload = User::find($request->user_id);

        if($user_cover_pic_upload->type =='User' && $user_cover_pic_upload->status == 'active'){

            if($request->cover_pic != ''){
                $image = $request->cover_pic;
                $filename =$request->user_id . rand(). '.'. $image->getClientOriginalExtension();
                $location = public_path('assets/user/cover');
                $image->move($location, $filename);
                $user_cover_pic_upload->cover_pic = $filename;

            }
                $user_cover_pic_upload->save();

            return response()->json([
                'message' => 'Cover successfully updated',
                'status'  => true
            ],200);

        }

        else{
            return response()->json(['error'=>'Something error']);
        }


    }


    public function coverPic(Request $request){

        $user_cover_pic = User::find($request->user_id);

        $cover_pic = 'https://muslimmatrimonywell.com' . '/' . 'public/assets/user/cover/'.  $user_cover_pic->cover_pic;

        return response()->json([
            'cover_pic' => $cover_pic,
            'status'  => true
        ],200);

    }

    public function shortBioStore(Request $request){

        $shortBio = User::find($request->user_id);
        $shortBio->short_bio = $request->short_bio;
        $shortBio->save();

        return response()->json([
            'message' => 'Short Bio successfully updated',
            'status'  => true
        ],200);

    }


     public function showProfilePost(Request $request){

        $postlists = Post::orderBy('created_at', 'DESC')->where('user_id',  $request->user_id)
                    ->get();

        foreach ($postlists  as $key => $postlist) {

            $isreact = PostReact::where('post_id', $postlist->id)
                        ->where('user_id', Auth::user()->id)->get();
            $iscomment = PostComment::where('post_id', $postlist->id)
                        ->where('user_id', Auth::user()->id)->get();



            if ($postlist->image != null || $postlist->image != '') {


            //   dd(count($isreact));

               if(count($isreact)==0 && count($iscomment)==0){

                   $data[]=[
                        'id' => $postlist->id,
                        'user_id' => $postlist->user_id,
                        'userName' => $postlist->getPostUser->name,
                        'profile' => 'https://muslimmatrimonywell.com' . '/' . 'public/assets/user/'.  $postlist->getPostUser->image,
                        'login_status' => $postlist->getPostUser->login_status,
                        'description' => $postlist->description,
                        'image' =>'https://muslimmatrimonywell.com' . '/' . 'public/upload/post/'. $postlist->image,
                        'tag' => $postlist->tag,
                        'view' => $postlist->view,
                        'like' => count($postlist->number_of_like) ?? '',
                        'comment' => count($postlist-> getPostCommentAll) ?? '',
                        'status' => $postlist->status,
                        'isReact' => 'NoReact',
                        'isComment' => 'NoComment',
                        'created_at' => $postlist->created_at,
                        'updated_at' => $postlist->updated_at,
                    ];
               }

               elseif(count($isreact)==0 && count($iscomment)!=0){

                   $data[]=[
                        'id' => $postlist->id,
                        'user_id' => $postlist->user_id,
                        'userName' => $postlist->getPostUser->name,
                        'profile' => 'https://muslimmatrimonywell.com' . '/' . 'public/assets/user/'.  $postlist->getPostUser->image,
                        'login_status' => $postlist->getPostUser->login_status,
                        'description' => $postlist->description,
                        'image' =>'https://muslimmatrimonywell.com' . '/' . 'public/upload/post/'. $postlist->image,
                        'tag' => $postlist->tag,
                        'view' => $postlist->view,
                        'like' => count($postlist->number_of_like) ?? '',
                        'comment' => count($postlist-> getPostCommentAll) ?? '',
                        'status' => $postlist->status,
                        'isReact' => 'NoReact',
                        'isComment' => 'YseComment',
                        'created_at' => $postlist->created_at,
                        'updated_at' => $postlist->updated_at,
                    ];
               }

               elseif(count($isreact)!=0 && count($iscomment)==0){

                   $data[]=[
                        'id' => $postlist->id,
                        'user_id' => $postlist->user_id,
                        'userName' => $postlist->getPostUser->name,
                        'profile' => 'https://muslimmatrimonywell.com' . '/' . 'public/assets/user/'.  $postlist->getPostUser->image,
                        'login_status' => $postlist->getPostUser->login_status,
                        'description' => $postlist->description,
                        'image' =>'https://muslimmatrimonywell.com' . '/' . 'public/upload/post/'. $postlist->image,
                        'tag' => $postlist->tag,
                        'view' => $postlist->view,
                        'like' => count($postlist->number_of_like) ?? '',
                        'comment' => count($postlist-> getPostCommentAll) ?? '',
                        'status' => $postlist->status,
                        'isReact' => 'YesReact',
                        'isComment' => 'NoComment',
                        'created_at' => $postlist->created_at,
                        'updated_at' => $postlist->updated_at,
                    ];
               }

               else{

                    $data[]=[
                        'id' => $postlist->id,
                        'user_id' => $postlist->user_id,
                        'userName' => $postlist->getPostUser->name,
                        'profile' => 'https://muslimmatrimonywell.com' . '/' . 'public/assets/user/'.  $postlist->getPostUser->image,
                        'login_status' => $postlist->getPostUser->login_status,
                        'description' => $postlist->description,
                        'image' =>'https://muslimmatrimonywell.com' . '/' . 'public/upload/post/'. $postlist->image,
                        'tag' => $postlist->tag,
                        'view' => $postlist->view,
                        'like' => count($postlist->number_of_like) ?? '',
                        'comment' => count($postlist-> getPostCommentAll) ?? '',
                        'status' => $postlist->status,
                        'isReact' => 'YesReact',
                        'isComment' => 'YesComment',
                        'created_at' => $postlist->created_at,
                        'updated_at' => $postlist->updated_at,
                    ];

               }

            }

        }



        return response()->json(['data'=>$data],200);


    }

    public function profileMakePublicPrivate(){

        $user = User::find(Auth::user()->id);

        if($user->image_status == 0){

            $user->image_status = 1;
            $user->save();
            return response()->json(['message' => 'Profile Make Private successfully'], 200);
        }

        else{

            $user->image_status = 0;
            $user->save();
            return response()->json(['message' => 'Profile Make Public successfully'], 200);
        }


    }

    // public function profileMakePrivate(){

    //     $user = User::find(Auth::user()->id);

    //     $user->image_status = 1;

    //     $user->save();

    //     return response()->json(['message' => 'Profile Make Private successfully'], 200);
    // }





}
