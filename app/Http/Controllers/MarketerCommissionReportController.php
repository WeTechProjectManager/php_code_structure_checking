<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MarketerCommission;
use App\Models\MarketerCommissionPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketerCommissionReportController extends Controller
{
    public function index(Request $request)
    {
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $marketer_id = $request->marketer_id;
        $date = $request->date;

        $marketerInfo = "";
        if($marketer_id){
            $marketerInfo = User::query()->find($marketer_id);
        }

        # marketer commission data
        $marketer_commissions = MarketerCommission::query()
            ->where(function ($q) use ($marketer_id,$date){
                if($marketer_id)
                    $q->where('marketer_id',$marketer_id);
                if($date)
                    $q->whereDate('created_at',$date);
            })
            ->orderBy('id','desc')
            ->simplePaginate(20);

        # total commission
        $total_marketer_commission = MarketerCommission::query()
            ->where(function ($q) use ($marketer_id,$date){
                if($marketer_id)
                    $q->where('marketer_id',$marketer_id);
                if($date)
                    $q->whereDate('created_at',$date);
            })
            ->sum('amount');


        # total list
        $total_list_count = MarketerCommission::query()
            ->where(function ($q) use ($marketer_id,$date){
                if($marketer_id)
                    $q->where('marketer_id',$marketer_id);
                if($date)
                    $q->whereDate('created_at',$date);
            })
            ->count();

        # total commission paid
        $total_marketer_commission_paid = MarketerCommissionPayment::query()
            ->where(function ($q) use ($marketer_id,$date){
                if($marketer_id)
                    $q->where('marketer_id',$marketer_id);
                if($date)
                    $q->whereDate('created_at',$date);
            })
            ->sum('amount');

        return view('marketer.marketer_commission_report',compact('marketer_commissions','total_marketer_commission','marketer_id','total_list_count','marketerInfo','total_marketer_commission_paid'));
    }
}
