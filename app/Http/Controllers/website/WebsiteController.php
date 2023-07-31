<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;


class WebsiteController extends Controller
{
    public function home()
    {
        return view('website.home');
    }
}
