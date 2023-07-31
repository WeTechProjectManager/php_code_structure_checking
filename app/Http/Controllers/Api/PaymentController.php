<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MyChoice;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Conversation;
use App\Models\MarketerCommission;
use App\Models\MyFrind;
use App\Models\Referral;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $validate = $request->validate([

            'paid_for'                => 'required',
            'transaction_id'          => 'required',
            'amount'                  => 'required',
            'date'                    => 'required',
            'status'                  => 'required',
        ]);
        $user_id = Auth::user()->id;

        $setup = DB::table('marketer_commission_setups')->first();

        $merketer_com = $setup->commission_percent;

        $merketer  = Referral::where('user_id', $user_id)->first();
        $merketer_id = $merketer->marketer_id;

        $user = new Payment();
        $user->user_id = $user_id;
        $user->paid_for = $request->paid_for;
        $user->transaction_id = $request->transaction_id;
        $user->amount = $request->amount;
        $user->date = $request->date;
        $user->status = $request->status;
        $user->save();


        // $rate = (parseFloat($user->amount) * (parseFloat($merketer_com) / 100));

        $amount = floatval($user->amount);
        $commissionPercentage = floatval($merketer_com);

        // Calculate the rate
        $rate = $amount * ($commissionPercentage / 100);


        $merketer_commission = new MarketerCommission();
        $merketer_commission->marketer_id =  $merketer_id;
        $merketer_commission->transaction_id = $user->transaction_id;
        $merketer_commission->amount =  $rate;
        $merketer_commission->status =  $user->status;
        $merketer_commission->save();

        MyChoice::where('user_id', $user->user_id)
            ->where('choice_id', $user->paid_for)
            ->update(['payment' => 'paid']);


        Conversation::where('sender_id', $user->user_id)
            ->where('receiver_id', $user->paid_for)
            ->update(['paid' => 'yes']);

        MyFrind::create([
            'user_id' => $user->user_id, 'friend_id' => $user->paid_for, 'status' => $user->status, 'delete_friend' => 0,
            'deleted_by' => 0
        ]);

        return response()->json(['message' => 'Payment successfully Done'], 200);
    }

    public function show_my_transaction()
    {
        $user_id = Auth::user()->id;

        $show_all_my_transaction = Payment::where('user_id', $user_id)
            ->orderBy('payments.id', 'desc')
            ->get();

        $response = [
            'show_all_my_transaction' => $show_all_my_transaction,
        ];
        return response()->json($response);
    }
}
