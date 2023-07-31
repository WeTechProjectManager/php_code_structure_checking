<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    public function index(Request $request)
    {
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $date = $request->date;
        $adminNotifications = AdminNotification::query()
            ->where(function ($q) use ($date){
                if($date)
                    $q->whereDate('created_at',$date);
            })
            ->orderBy('id','desc')
            ->simplePaginate(15);

        # total adminNotification with search criteria
        $total_admin_notification = AdminNotification::query()
            ->where(function ($q) use ($date){
                if($date)
                    $q->whereDate('created_at',$date);
            })
            ->count();

        return view('adminNotification.index',compact('adminNotifications','total_admin_notification'));
    }

    public function store(Request $request)
    {
        AdminNotification::query()->insert([
            'title'          => $request->title,
            'description'    => $request->description,
            'created_at'     => Carbon::now(),
        ]);

        Toastr::success('Data added successfully','Success');
        return redirect()->back();
    }

}
