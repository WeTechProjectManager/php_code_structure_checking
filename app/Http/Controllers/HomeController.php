<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    public function websiteHomePage(){
        return view('website.home.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // main dashboard
    public function index()
    {
        if( Auth::user()->type=='Admin')
        {
            return view('dashboard.dashboard');
        }
        else if( Auth::user()->type=='Marketer')
        {
            return view('dashboard.marketerDashboard');
        }
        else
        {
            return view('dashboard.userDashboard');
        }

    }

}
