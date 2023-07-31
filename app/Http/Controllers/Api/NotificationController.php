<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function show_my_notification()
    {
        $user_id = Auth::user()->id;


        // $profile_vistitors_notification = Notification::join('users', 'users.id', '=', 'notifications.created_by')
        //     ->where('read_by', $user_id)->get();

        // foreach ($profile_vistitors_notification  as $key => $visitors) {
        //     if ($visitors->image != null || $visitors->image != '') {
        //         $profile_vistitors_notification[$key]['image'] = config('app.url') . '/' . 'public/assets/user/' . $visitors->image;
        //     } else {
        //         $profile_vistitors_notification[$key]['image'] = '';
        //     }
        // }



        $admin_notifications = DB::table('admin_notifications')->get();

        $post_notification = Notification::join('users', 'users.id', '=', 'notifications.created_by')->get();

        foreach ($post_notification  as $key => $visitor) {
            if ($visitor->image != null || $visitor->image != '') {
                $post_notification[$key]['image'] = config('app.url') . '/' . 'public/assets/user/' . $visitor->image;
            } else {
                $post_notification[$key]['image'] = '';
            }
        }

        foreach ($post_notification  as $key => $visitor) {
            if ($visitor->cover_pic != null || $visitor->cover_pic != '') {
                $post_notification[$key]['cover_pic'] = config('app.url') . '/' . 'public/assets/user/cover/' . $visitor->cover_pic;
            } else {
                $post_notification[$key]['cover_pic'] = '';
            }
        }

        return response()->json(['admin_notifications' => $admin_notifications, 'post_notification' => $post_notification], 200);
    }
}
