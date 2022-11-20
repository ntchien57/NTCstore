<?php

namespace App\Http\Controllers;

use App\Http\Service\OrderStatus\OrderStatusService;
use App\Models\Cart;
use Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    protected $orderStatusService;

    public function __construct(OrderStatusService $orderStatusService)
    {
        $this->orderStatusService =$orderStatusService;
    }

    public function show(){
        $customer = Customer::select('id','name','phone','address','created_at','active')
        ->orderByDesc('id')->where('user_id', Auth::user()->id)
        ->with('carts')
        ->get();
        // dd($customer);
        return view('orderstatus.orderstatus',[
            'title'=> 'Trạng thái đơn hàng',
            'customers' => $customer
        ]);
    }

    public function destroy(Request $request)
    {   $id = $request->input('id');
        $actives = Customer::orderByDesc('id')->where('id',$id)->get();
        foreach($actives as $active){
            if ($active->active == 0){
                Customer::where('id',$id)->update([
                    'active'=> '3'
                ]);
                Toastr::success('Hủy đơn hàng thành công', 'Thành công');
            }elseif ($active->active == 1){
                Toastr::error('Đơn hàng đang giao không thể hủy', 'Thất bại');
            }
            elseif ($active->active == 2) {
                Toastr::warning('Đơn hàng của bạn đã giao thành công', 'Cảnh báo');
            }
    
            return true;
        }
       
    }
}
