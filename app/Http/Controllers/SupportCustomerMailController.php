<?php

namespace App\Http\Controllers;

use App\Mail\SupportCustomer;
use Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Alert;

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

        return redirect('/contact');

        Alert::success('Thành công','Cảm ơn bạn đã liên hệ chúng tôi sẽ phản hồi sớm nhất có thể');

    }


}
