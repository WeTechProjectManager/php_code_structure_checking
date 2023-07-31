<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MyChoice;
use App\Models\MyFrind;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class ChoiceController extends Controller
{
    public function show_my_choice(Request $request)
    {
        $user_id = Auth::user()->id;

        $mychoice = MyChoice::join('users', 'users.id', '=', 'my_choices.choice_id')
            ->where('my_choices.user_id', $user_id)
            ->get();

        // dd( $mychoice);

        foreach ($mychoice  as $key => $choice) {
            if ($choice->image != null || $choice->image != '') {
                $mychoice[$key]['image'] = config('app.url') . '/' . 'public/assets/user/' . $choice->image;
            } else {
                $mychoice[$key]['image'] = '';
            }
        }


        foreach ($mychoice  as $key => $choice) {
            if ($choice->cover_pic != null || $choice->cover_pic != '') {
                $mychoice[$key]['cover_pic'] = config('app.url') . '/' . 'public/assets/user/cover/' . $choice->cover_pic;
            } else {
                $mychoice[$key]['cover_pic'] = '';
            }
        }

        $response = [
            'my_choice_list' => $mychoice,
        ];
        return response()->json($response);
    }

    public function my_choice(Request $request)
    {
        $validate = $request->validate([
            'choice_id'                    => 'required',
        ]);

        $mychoice = new MyChoice();
        $mychoice->user_id = Auth::user()->id;
        $mychoice->choice_id =  $request->choice_id;
        $mychoice->payment = 'non_paid';
        $mychoice->save();

        $user_details = User::where('id', $mychoice->user_id)->first();

        $name = $user_details->name;
        $msg = "Choice You";
        $message = $name . " " . $msg;

        $notification = new Notification();
        $notification->message = $message;
        $notification->date = date('Y-m-d');
        $notification->created_by = Auth::user()->id;
        $notification->read_by = $mychoice->choice_id;
        $notification->save();


        if ($mychoice) {
            return response()->json(['message' => 'Your Choice Added Successfully'], 200);
        } else {
            return response()->json(['message' => 'Something Went Worng'], 404);
        }
    }

    public function show_choice_me(Request $request)
    {
        $user_id = Auth::user()->id;

        $choice_me_list = MyChoice::join('users', 'users.id', '=', 'my_choices.choice_id')
            ->where('my_choices.choice_id',  $user_id)
            ->where('my_choices.deleted_by', 0)
            ->get();

        foreach ($choice_me_list  as $key => $choice) {
            if ($choice->image != null || $choice->image != '') {
                $choice_me_list[$key]['image'] = config('app.url') . '/' . 'public/assets/user/' . $choice->image;
            } else {
                $choice_me_list[$key]['image'] = '';
            }
        }


        foreach ($choice_me_list  as $key => $choice) {
            if ($choice->cover_pic != null || $choice->cover_pic != '') {
                $choice_me_list[$key]['cover_pic'] = config('app.url') . '/' . 'public/assets/user/cover/' . $choice->cover_pic;
            } else {
                $choice_me_list[$key]['cover_pic'] = '';
            }
        }


        $response = [
            'choice_me_list' => $choice_me_list,
        ];
        return response()->json($response);
    }

    public function show_my_friend(Request $request)
    {
        $user_id = Auth::user()->id;

        // $my_friend_list = MyChoice::join('users', 'users.id', '=', 'my_choices.choice_id')
        //     ->where('my_choices.user_id', $user_id)
        //     ->where('my_choices.payment',  'paid')
        //     ->where('my_choices.delete_friend',  0)
        //     ->get();

        $my_friend_list = MyFrind::join('users', 'users.id', '=', 'my_frinds.friend_id')
            ->where('my_frinds.user_id', $user_id)
            ->where('my_frinds.delete_friend',  0)
            ->get();

        foreach ($my_friend_list  as $key => $friend) {
            if ($friend->image != null || $friend->image != '') {
                $my_friend_list[$key]['image'] = config('app.url') . '/' . 'public/assets/user/' . $friend->image;
            } else {
                $my_friend_list[$key]['image'] = '';
            }
        }

        foreach ($my_friend_list  as $key => $friend) {
            if ($friend->cover_pic != null || $friend->cover_pic != '') {
                $my_friend_list[$key]['cover_pic'] = config('app.url') . '/' . 'public/assets/user/cover/' . $friend->cover_pic;
            } else {
                $my_friend_list[$key]['cover_pic'] = '';
            }
        }

        $response = [
            'my_friend_list' => $my_friend_list,
        ];
        return response()->json($response);
    }

    public function delete_my_friend(Request $request)
    {
        $user_id = Auth::user()->id;
        // dd($request->friend_id);

        $my_friend_list = MyFrind::where('my_frinds.user_id', $user_id)
            ->where('my_frinds.friend_id',  $request->friend_id)
            ->update(['my_frinds.delete_friend' => 1, 'my_frinds.deleted_by' => $user_id]);

        return response()->json(['message' => 'Deleted Successfully'], 200);
    }

    public function delete_my_choice(Request $request)
    {
        $user_id = Auth::user()->id;
        // dd($request->friend_id);

        MyChoice::where('my_choices.user_id', $user_id)
            ->where('my_choices.choice_id',  $request->friend_id)
            ->update(['my_choices.delete_friend' => 1, 'my_choices.deleted_by' => $user_id]);

        return response()->json(['message' => 'My Choice Deleted Successfully'], 200);
    }

    public function delete_choice_me(Request $request,)
    {
        $user_id = Auth::user()->id;

        $my_friend_list = MyChoice::where('my_choices.user_id', $request->friend_id)
            ->where('my_choices.choice_id',  $user_id)
            ->update(['my_choices.delete_friend' =>  1, 'my_choices.deleted_by' => $user_id]);

        return response()->json(['message' => 'Choice Me Deleted Successfully'], 200);
    }
}
