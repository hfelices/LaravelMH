<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('posts.index');
    }
    public function about_mark()
    {
        return view('geomir.about_mark');
    }

    public function aboutus()
    {
        return view('geomir.aboutus');
    }
 
}
