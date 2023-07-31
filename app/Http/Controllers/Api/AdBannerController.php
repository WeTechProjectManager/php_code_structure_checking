<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdBanner;
use Illuminate\Http\Request;

class AdBannerController extends Controller
{
    public function store(Request $request){


        $request->validate([
            'image' =>'image|max:2048|dimensions:width=300,height=100',
        ]);

        $adbanner = new AdBanner();

        $adbanner->description = $request->description;
        $adbanner->second = $request->second;
        if($request->image != ''){
            $image = $request->image;
            $filename =time(). rand(). '.'. $image->getClientOriginalExtension();
            $location = public_path('upload/adBanner');
            $image->move($location, $filename);
            $adbanner->image = $filename;
        }
        $adbanner->save();


        return response()->json([
            'message' => 'Ad Banner store successfully',
            'status'  => true,
        ],200);

    }

    public function show(){

        $ad_banners = AdBanner::all();

        if(count($ad_banners)!=0){
            // dd(count($ad_banners));
            foreach ($ad_banners  as $key => $ad_banner) {
                if ($ad_banner->image != null || $ad_banner->image != '') {
                    $ad_banners[$key]['image'] = config('app.url') . '/' . 'upload/adBanner' .$ad_banner->image;
                }
                else {
                    $ad_banners[$key]['image'] = '';
                }
            }

            return response()->json ([
                'ad_banners' => $ad_banners,
                'status'  => true,
            ],200);
        }

        else{

            return response()->json ([
                'message' => 'There is no Ad Banner',
                'status'  => true,
            ],200);

        }


    }

}
