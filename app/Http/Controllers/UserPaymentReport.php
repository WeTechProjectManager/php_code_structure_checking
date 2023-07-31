<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPaymentReport extends Controller
{
    public function index(Request $request)
    {
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $user_id = $request->user_id;
        $date = $request->date;

        $payments = Payment::query()
            ->where(function ($q) use ($user_id,$date){
                if($user_id)
                    $q->where('user_id',$user_id);
                if($date)
                    $q->whereDate('created_at',$date);
            })
            ->orderBy('id','desc')
            ->simplePaginate(20);

        $total_payment = Payment::query()
            ->where(function ($q) use ($user_id,$date){
                if($user_id)
                    $q->where('user_id',$user_id);
                if($date)
                    $q->whereDate('created_at',$date);
            })
            ->sum('amount');

        return view('usermanagement.user_payment_report',compact('payments','total_payment','user_id'));
    }
}
