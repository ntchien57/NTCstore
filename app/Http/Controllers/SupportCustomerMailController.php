<?php

namespace App\Http\Controllers;

use App\Mail\SupportCustomer;
use Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SupportCustomerMailController extends Controller
{


    public function support(Request $request){
        $email = $request->input('email');
        $msg = $request->input('msg');

        $supports = Session::get('support');
        if(is_null($supports)){
            Session::put('support',[
                'email'=>$email,
                'msg' => $msg
            ]);
        }
        
        return redirect()->route('support');
    }

    public function index(){

        Mail::to("ntchien5701@gmail.com")->send(new SupportCustomer);

        Toastr::success('Thành công','Cảm ơn bạn đã liên hệ chusngtooi sẽ phản hồi sớm nhất có thể');

        return redirect('/contact');
    }


}
