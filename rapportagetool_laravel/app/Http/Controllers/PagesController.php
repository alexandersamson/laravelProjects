<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $data = array(
            'title' => 'Index Page'
        );
        return view('pages.index')->with($data);
    }

    public function about(){
        $data = array(
            'title' => 'About Page'
        );
        return view('pages.about')->with($data);
    }

    public function services(){
        $data = array(
            'title' => 'Services Page',
            'services' => ['SEO','Programming','Webdesign']
        );
        return view('pages.services')->with($data);
    }
}
