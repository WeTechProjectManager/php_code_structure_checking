<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileVisitor;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notification;

class VisitorController extends Controller
{

    public function visit_my_profile(Request $request)
    {
        $validate = $request->validate([
            'visit_id'                => 'required',
        ]);

        $user_id = Auth::user()->id;

        $user = new ProfileVisitor();
        $user->user_id = $user_id;
        $user->visit_id = $request->visit_id;
        $user->save();

        $user_details = User::where('id', $user->user_id)->first();

        $name = $user_details->name;
        $msg = "Visit Your Profile";

        $message = $name . " " . $msg;

        $notification = new Notification();
        $notification->message = $message;
        $notification->date = date('Y-m-d');
        $notification->created_by = Auth::user()->id;
        $notification->read_by = $user->visit_id;
        $notification->save();

        return response()->json(['message' => 'Visitor Added successfully Done'], 200);
    }

    public function show_visit_my_profile(Request $request)
    {
        $user_id = Auth::user()->id;

        $my_profile_visitor = ProfileVisitor::join('users', 'users.id', '=', 'profile_visitors.user_id')
            ->where('profile_visitors.visit_id', $user_id)
            ->orderBy('profile_visitors.id', 'desc')
            ->get();

        foreach ($my_profile_visitor  as $key => $visitors) {
            if ($visitors->image != null || $visitors->image != '') {
                $my_profile_visitor[$key]['image'] = config('app.url') . '/' . 'public/assets/user/' . $visitors->image;
            } else {
                $my_profile_visitor[$key]['image'] = '';
            }
        }

        foreach ($my_profile_visitor  as $key => $visitors) {
            if ($visitors->cover_pic != null || $visitors->cover_pic != '') {
                $my_profile_visitor[$key]['cover_pic'] = config('app.url') . '/' . 'public/assets/user/cover/' . $visitors->cover_pic;
            } else {
                $my_profile_visitor[$key]['cover_pic'] = '';
            }
        }

        $response = [
            'my_profile_visitor' => $my_profile_visitor,
        ];
        return response()->json($response);
    }
}
