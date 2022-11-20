<?php

namespace App\Http\Service\OrderStatus;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class OrderStatusService
{
    public function getOrderStatus(){
        return Cart::orderByDesc('id')->where('user_id',Auth::user()->id)->with(['product'=> function($query){
            $query->select('id','name','thumb');
        }])
            ->get();
    }

    public function getLastCustomerIdByUserId($user_id){
        return Cart::select('customer_id')->where('user_id',$user_id)->where()->orderByDesc('id');
    }
}
