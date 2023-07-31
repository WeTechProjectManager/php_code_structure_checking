<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetup;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentSetupController extends Controller
{
    public function index(Request $request){
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $amount_bdt    = $request->amount_bdt;
        $amount_dollar = $request->amount_dollar;
        $paymentSetup = PaymentSetup::query()
            ->where(function ($q) use ($amount_bdt,$amount_dollar){
                if($amount_bdt)
                    $q->where('amount_bdt',$amount_bdt);
                if($amount_dollar)
                    $q->where('amount_dollar',$amount_dollar);
            })
            ->get();

        # total payment setup
        $total_paymentSetup = PaymentSetup::query()
            ->where(function ($q) use ($amount_bdt,$amount_dollar){
                if($amount_bdt)
                    $q->where('amount_bdt',$amount_bdt);
                if($amount_dollar)
                    $q->where('amount_dollar',$amount_dollar);
            })
            ->count();

        $amount_duration = [];
        foreach ($paymentSetup as $ps){
            $previousData = PaymentSetup::query()->find(($ps->id)+1);
            if($previousData){
                $amount_duration[]=['duration'=>$previousData->created_at];
            }
            else{
                $amount_duration[]=['duration'=> ""];
            }
        }

           // dd($amount_duration);

        return view('paymentSetup.index',compact('paymentSetup','total_paymentSetup','amount_duration'));
    }

    public function store(Request $request){

        $data = [
            'amount_bdt'     => $request->amount_bdt,
            'amount_dollar'  => $request->amount_dollar,
            'created_at'     => Carbon::now(),
        ];

        PaymentSetup::query()->insert($data);

        Toastr::success('Success','Success');
        return redirect()->back();
    }
}
