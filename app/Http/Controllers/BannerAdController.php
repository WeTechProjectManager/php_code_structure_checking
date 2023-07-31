<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdBanner;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BannerAdController extends Controller
{
    public function index(Request $request)
    {
        if( !(Auth::user()->type=='Admin') )
            return redirect()->route('home');

        $date = $request->date;
        $banners = AdBanner::query()
            ->where(function ($q) use ($date){
                if($date)
                    $q->whereDate('created_at',$date);
            })
            ->orderBy('id','desc')
            ->simplePaginate(10);

        # total banner with search criteria
        $total_banner = AdBanner::query()
            ->where(function ($q) use ($date){
                if($date)
                    $q->whereDate('created_at',$date);
            })
            ->count();

        return view('bannerAd.index',compact('banners','total_banner'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image'     => 'required|mimes:jpg,jpeg,png,bmp,tiff ',
        ]);

        if (!empty($request->image))
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/adBanner'), $image);
        }
        else
            $image='';

        AdBanner::query()->insert([
           'description'    => $request->description,
           'image'          => $image,
           'second'         => $request->second,
           'created_at'     => Carbon::now(),
        ]);

        Toastr::success('Data added successfully','Success');
        return redirect()->back();

    }

}
