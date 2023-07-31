<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MarketerCommissionSetup;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketerCommissionSetupController extends Controller
{
    public function index(){
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $data = MarketerCommissionSetup::query()->first();
        return view('marketer.commission_setup',compact('data'));
    }

    public function update(Request $request){
        $commissionData = MarketerCommissionSetup::query()->first();
        $data = [
            'commission_percent'  => $request->commission_percent,
        ];
        if($commissionData){
            MarketerCommissionSetup::query()->update($data);
        }
        else{
            MarketerCommissionSetup::query()->create($data);
        }

        Toastr::success('Success','Success');
        return redirect()->back();
    }
}
