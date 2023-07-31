<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MarketerCommissionPayment;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketerCommissionPaymentController extends Controller
{
    public function index(Request $request)
    {
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $marketer = User::query()->find($request->marketer_id);
        $marketer_id = $marketer->id;

        $date = $request->date;
        $marketerCommissionPayments = MarketerCommissionPayment::query()
            ->where(function ($q) use ($date){
                if($date)
                    $q->whereDate('created_at',$date);
            })
            ->where('marketer_id',$marketer_id)
            ->orderBy('id','desc')
            ->get();

        # total paid amount  with search criteria
        $total_paid_amount= MarketerCommissionPayment::query()
            ->where(function ($q) use ($date){
                if($date)
                    $q->whereDate('created_at',$date);
            })
            ->where('marketer_id',$marketer_id)
            ->sum('amount');

        return view('marketer.marketer_commission_payment',compact('marketerCommissionPayments','total_paid_amount','marketer','marketer_id'));
    }

    public function store(Request $request)
    {
        $marketer = User::query()->find($request->marketer_id);

        MarketerCommissionPayment::query()->insert([
            'marketer_id'       => $request->marketer_id,
            'amount'            => $request->amount,
            'payment_method'    => $request->payment_method,
            'created_at'        => Carbon::now(),
        ]);

        Toastr::success('Payment successfully','Success');
        return redirect()->back();
    }
}
