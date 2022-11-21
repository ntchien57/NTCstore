<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function show(){
        return view('information.infor',[
            "title" => "Giới thiệu về NTC Store"
        ]);
    }

    public function contact(){
        return view('information.contact',[
            "title" => "Liên hệ với NTC Store"
        ]);
    }
}
