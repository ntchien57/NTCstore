<?php

namespace App\Http\Service\Cart;
use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Toastr;
use Illuminate\Support\Arr;

class CartService
{
    public function creat($request)
    {
        $qty = (int)$request->input('num-product');
        $product_id = (int)$request->input('product-id');
        $size = $request->input('size');
        $number_available = Product::select('available')->where('id',$product_id)->first();
        if( $qty <= 0 || $product_id <= 0)
            {
                Toastr::error('Số lượng mua tối thiểu là 1','Cảnh báo');
                return false;
            }

        elseif($qty>$number_available->available){
            Toastr::error('Số lượng đặt hàng vượt quá số lượng có sẵn','Cảnh báo');
            return false;
        }

        $carts = Session::get('carts');
        if(is_null($carts)){
            Session::put('carts',[
                $product_id => $qty,
            ]);

            return true;
        }

        $exists = Arr::exists($carts,$product_id);

        if($exists){
            $carts[$product_id] = $carts[$product_id] + $qty;
            Session::put('carts',$carts); 
            return true;
        }
 
        $carts[$product_id] = $qty;
        Session::put('carts',$carts); 
        return true;

    }

    public function getProduct()
    {

        $carts = Session::get('carts');
        if (is_null($carts)){
            return [];
        }

        $productId = array_keys($carts);


        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active',1)
            ->whereIn('id',$productId)
            ->get();
    }

    public function update($request)
    {
        Session::put('carts', $request->input('num-product'));

        return true;
    }

    public function remove($id)
    {
        $carts = Session::get('carts', $id);

        unset($carts[$id]);

        Session::put('carts',$carts);
        return true;
    }

    public function order($request)
    {
        try {
            DB::beginTransaction();

            $carts = Session::get('carts');
            if (is_null($carts)) return false;
            $customer = Customer::create([
                'name'=> $request->input('name'),
                'phone'=> $request->input('phone'),
                'address'=> $request->input('address'),
                'email'=> $request->input('email'),
                'note'=> $request->input('note'),
                'active'=> '0',
                'user_id'=> Auth::user()->id ?? 0
            ]);          


            $this->infoProductCart($carts, $customer->id );


            DB::commit();

            Session::forget('carts');
        }catch (\Exception $err)
        {
            DB::rollBack();

            return false;
        }

        return true;
    }

    public function infoProductCart($carts,$customer_id)
    {
        $productId = array_keys($carts);
        $products =  Product::select('id', 'name', 'price', 'price_sale', 'thumb','available')
            ->where('active',1)
            ->whereIn('id',$productId)
            ->get();
        foreach ($products as $key => $product){

            $num = $product->available - $carts[$product->id];
            $product->available = $num;
            $product->save();
       
            $data[] = [
                'customer_id' => $customer_id,
                'product_id' => $product->id,
                'qty'=> $carts[$product->id],
                'price'=> $product->price_sale != 0 ? $product->price_sale : $product->price,
                'active'=> '0',
                'user_id'=> isset(Auth::user()->id) ? Auth::user()->id : null,               
            ];
        }
       return Cart::insert($data);
    }

    public function getCustomer()
    {
        return Customer::orderByDesc('id')->search()->paginate(9);
    }

    public function getProductForCart($customer){
      return  $customer->carts()->with(['product'=> function($query){
          $query->select('id','name','thumb');
      }])->get();
    }

}
