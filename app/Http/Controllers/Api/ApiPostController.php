<?php

namespace App\Http\Controllers\Api;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostReact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class ApiPostController extends Controller
{
     public function store(Request $request){

        $request->validate([
            'description' => 'required',
            'image' => 'image',
        ]);

        $user = User::find($request->user_id);
        if($user ->type =='User' && $user ->status == 'active'){

            $create_post = new Post();
            $create_post->user_id = $request->user_id;
            $create_post->description = $request->description;

            if($request->tag != ''){
                $create_post->tag = $request->tag;
            }
            if($request->image != ''){
                $image = $request->image;
                $filename =time(). rand(). '.'. $image->getClientOriginalExtension();
                $location = public_path('upload/post');
                $image->move($location, $filename);
                $create_post->image = $filename;
            }
            $create_post->save();


        #save notification
        $user_details = User::where('id', $request->user_id)->first();

        $name = $user_details->name;
        $msg = "Shared a post";

        $message = $name . " " . $msg;

        $notification = new Notification();
        $notification->message = $message;
        $notification->date = date('Y-m-d');
        $notification->created_by = $request->user_id;
        $notification->read_by = '';
        $notification->save();



            $user_post_count = Post::where('user_id', $request->user_id)->get();

            if(count($user_post_count) >10){
                $user_post_count = Post::where('user_id', $request->user_id)
                                   ->orderBy('id')->first()->delete();
            }

            return response()->json([
                'message' => 'Upload successfully',
                'status'  => true
            ],200);

        }

        else{
            return response()->json(['error'=>'Something error']);
        }

    }


    public function show(){

        $postlists = Post::orderBy('created_at', 'DESC')->get();

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


    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 10; // Number of records per page

    $currentPageData = array_slice($data, ($currentPage - 1) * $perPage, $perPage);

    $paginatedData = new LengthAwarePaginator($currentPageData, count($data), $perPage);
    $paginatedData->setPath(request()->url());




    return ($paginatedData);


    }

    public function delete($post_id){

        $post = Post::find($post_id);

        if($post != null){

            if($post->user_id == Auth::user()->id){

                $post->delete();

                return response()->json([
                    'message' => 'Post successfully delete',
                    'status' => true,
                ],200);

            }
            else{
                return response()->json([
                    'error' => 'something error',
                ]);
            }
        }

        else{

            return response()->json([
                'error' => 'There is no post',
            ]);
        }


    }

    public function postViewStore(Request $request){

        if( Auth::user()->type =='User' && Auth::user()->status == 'active'){

            $postview = Post::find($request->post_id);
            $postview->view = ($postview->view)+1;
            $postview->save();

            return response()->json([
                'message' => 'View successfully update',
                'status'  => true
            ],200);

        }

        else{
            return response()->json(['error'=>'Something error']);
        }


    }

    public function sharePostLink($post_id){

        $sharepost = Post::find($post_id);


        $data[]=[

            'id' => $sharepost->id,
            'user_id' => $sharepost->user_id,
            'userName' => $sharepost->getPostUser->name,
            'profile' => 'https://muslimmatrimonywell.com' . '/' . 'public/assets/user/'.  $sharepost->getPostUser->image,
            'login_status' => $sharepost->getPostUser->login_status,
            'description' => $sharepost->description,
            'image' =>'https://muslimmatrimonywell.com' . '/' . 'public/upload/post/'. $sharepost->image,
            'tag' => $sharepost->tag,
            'view' => $sharepost->view,
            'like' => count($sharepost->number_of_like) ?? '',
            'comment' => count($sharepost-> getPostCommentAll) ?? '',
            'status' => $sharepost->status,
            'created_at' => $sharepost->created_at,
            'updated_at' => $sharepost->updated_at,
         ];

          return response()->json([
                'data' => $data,
                'status'  => true
            ],200);



    }
}
