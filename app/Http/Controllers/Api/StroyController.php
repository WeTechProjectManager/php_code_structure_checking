<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class StroyController extends Controller
{
    public function show_story(Request $request)
    {
        $user_id = Auth::user()->id;
        // $user_stroy = Story::join('users', 'users.id', '=', 'stories.user_id')
        //     ->where('stories.user_id', '=', $user_id)->where('stories.status', 'active')
        //     ->get();

        $user_stroy = Story::join('users', 'users.id', '=', 'stories.user_id')
            // ->whereNotIn('stories.user_id', [$user_id])
            ->where('stories.status', 'active')
            ->orderBy('stories.user_id', 'asc')
            ->get();

        foreach ($user_stroy  as $key => $user_stroys) {
            if ($user_stroys->story_image != null || $user_stroys->story_image != '') {
                $user_stroy[$key]['story_image'] = config('app.url') . '/' . 'public/assets/storyImage/' . $user_stroys->story_image;
            } else {
                $user_stroy[$key]['story_image'] = '';
            }
        }

        foreach ($user_stroy  as $key => $user_stroys) {
            if ($user_stroys->image != null || $user_stroys->image != '') {
                $user_stroy[$key]['image'] = config('app.url') . '/' . 'public/assets/user/' . $user_stroys->image;
            } else {
                $user_stroy[$key]['image'] = '';
            }
        }


        foreach ($user_stroy  as $key => $user_stroys) {
            if ($user_stroys->cover_pic != null || $user_stroys->cover_pic != '') {
                $user_stroy[$key]['cover_pic'] = config('app.url') . '/' . 'public/assets/user/cover/' . $user_stroys->cover_pic;
            } else {
                $user_stroy[$key]['cover_pic'] = '';
            }
        }

        // $other_user_story = Story::join('users', 'users.id', '=', 'stories.user_id')
        //     ->whereNotIn('stories.user_id', [$user_id])
        //     ->where('stories.status', 'active')
        //     ->get();

        // foreach ($other_user_story  as $key => $user_stroys) {
        //     if ($user_stroys->story_image != null || $user_stroys->story_image != '') {
        //         $other_user_story[$key]['story_image'] = config('app.url') . '/' . 'assets/storyImage' . $user_stroys->story_image;
        //     } else {
        //         $other_user_story[$key]['story_image'] = '';
        //     }
        // }

        $response = [
            'user_story_details' => $user_stroy,
            // 'other_user_story' => $other_user_story,
        ];
        return response()->json($response);
    }

    public function save_story(Request $request)
    {

        $validate = $request->validate([
            'story_image'                    => 'required',

        ]);


        $story_limit = $request->story_limit_number;


        $user_id = Auth::user()->id;
        $user_check = Story::where('user_id', $user_id)->count();

        // if ($request->hasFile('story_image')) {
        //     $photo = $request->file('story_image');
        //     $filename = time() . '.' . $photo->getClientOriginalExtension();

        //     $destinationPath = public_path('assets/storyImage/');
        //     $photo->move($destinationPath, $filename);
        //      $user['image'] = config('app.url') . '/' . 'assets/user/' . $user['image'];
        // }



        $user_story_count = Story::where('user_id', $user_id)->get();

        // if (count($user_story_count) > 10) {
        //     $user_story_count = Story::where('user_id', $user_id)->delete();
        // }


        if ($request->hasfile('story_image')) {
            $file = $request->file('story_image');
            $filename = rand() . '.' . $file->getClientOriginalExtension();
            $file->move("assets/storyImage/", $filename);
        }


        if ($story_limit  >  $user_check) {
            $story = new Story();
            $story->user_id = $user_id;
            $story->story_image =  $filename;
            $story->status = 'active';
            $story->save();
        } else {
            return response()->json(['message' => 'Sorry, Your Story Limit End '], 404);
        }


        // $recordsToUpdate = Story::where('status', 'active')
        //     ->where('created_at', '<=', Carbon::now()->subHours(24))
        //     ->get();

        // foreach ($recordsToUpdate as $record) {

        //     $record->status = 'in_active';
        //     $record->save();
        // }

        if ($story) {
            return response()->json(['message' => 'Story Added Successfully'], 200);
        } else {
            return response()->json(['message' => 'Something Went Worng'], 404);
        }
    }

    public function delete_story(Request $request)
    {
        $user_id = Auth::user()->id;

        // dd($request->id);
        $delete =  Story::where('id', $request->id)->delete();

        if ($delete) {
            return response()->json(['message' => 'Story Deleted Successfully'], 200);
        } else {
            return response()->json(['error' => 'Something Went Worng'], 404);
        }
    }
}
