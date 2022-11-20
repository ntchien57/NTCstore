@extends('main')

@section('content')
    <div class="bor12 p-t-15 m-t-150 m-b-100 w-100 p-lr-150">
        <table class="table text-center w-100" style=" border: 1px solid #ddd; margin: auto">
            <tbody>
                <tr>
                    <th class="text-center text-bold" style="background-color: #70d32e; font-size: 20px" colspan="7">LỊCH SỬ
                        MUA HÀNG</th>
                </tr>
                @php $total = 0; @endphp
                @foreach ($customers as $key => $customer)
                    <tr  class="table_head">
                        <th class="column-1 text-center">Người nhận</th>
                        <th class="column-2 text-center">Số điện thoại</th>
                        <th class="column-3 text-center">Địa chỉ nhận hàng</th>
                        <th class="column-4 text-center">Ngày đặt</th>
                        <th style="font-size:22px" class="column-5 text-center">{!! \App\Helpers\Helper::activeOrder1($customer->active) !!}</th>
                    </tr>

                    <tr class="table_row">
                        <td class="column-1">{{ $customer->name }}</td>
                        <td class="column-2" style="text-align: center">{{ $customer->phone }}</td>
                        <td class="column-3 p-l-10" style="text-align: center">{{ $customer->address }}</td>
                        <td class="column-4">{{ $customer->created_at->format('H:m d-m-y') }}</td>
                        <td><button onclick="changeStatusOrder({{ $customer->id }})" type="button"
                                class="btn btn-danger btnCancel">Hủy đơn</button></td>
                    </tr>
                    @foreach ($customer->carts as $cart)                       
                        <tr class="table_row">
                            <td style="text-align: left;padding-left:40%" colspan="4" class="column-1">
                                <div class="">
                                    <img style="width: 50px" src="{{ $cart->product->thumb }}" alt="IMG">
                                    <span style="margin-right:10px">{{ $cart->product->name }}</span>
                                    <span style="text-align: left; color:rgb(163, 153, 153)"><span>x</span>{{ $cart->qty }}</span>

                                </div>
                            </td>
                            @php
                                $priceEnd = $cart->price * $cart->qty;
                                $total += $priceEnd;
                            @endphp
                            <td colspan="1" style="text-align: right; padding:30px 8% 0 0;" >
                                {{ number_format($priceEnd) }} <sup>đ</sup>
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="4" class="text-right" style="font-size: 20px; font-weight: bold">Tổng tiền</td>
                        <td colspan="1" style="color: red;font-size: 20px; font-weight: bold;">
                            {{ number_format($total) }}<sup>đ</sup>
                        </td>
                    </tr>


    </div>
    </div>
    </div>
    @endforeach

    <form id="btn-accept" method="post">
        <div class="modal fade" id="modalCancelShip" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="top:15%">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cảnh báo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn chắn chắn muốn hủy đơn hàng không?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button onclick="acceptChange()" type="submit" class="btn btn-danger">Accept</button>
                    </div>
                    @csrf
    </form>
    </tbody>
    </table>
    </div>

    <div id="detail-order">

    </div>

    <input type="hidden" id="orderId">



    <script>
        function changeStatusOrder(id) {
            document.getElementById('orderId').value = id;
            console.log(document.getElementById('orderId').value);
        };
    </script>
    <script>
        function acceptChange() {
            var orderId = $('#orderId').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/orderStatus/destroy/" + orderId,
                type: "POST",
                dataType: 'JSON',
                data: {
                    id: orderId
                },
                success: function(response) {
                    location.reload();
                }
            })
        }
    </script>

    <script>
        function viewStatusOrder(id) {
            var viewOder = document.getElementById("detail-order");
            $.ajax({
                url: "/orderStatus/show/" + id,
                type: "POST",
                dataType: 'JSON',
                data: {
                    id: id
                },
                success: function(response) {
                    detail = response.order;
                    console.log(detail);
                    viewOder.innerHTML += `
                        <div class="bor12 p-t-15 m-t-150 m-b-100 w-100">
                            <table class="table text-center w-100" style=" border: 1px solid #ddd; margin: auto">
                                <tbody>
                                        <tr class="table_head">
                                            <th class="column-1 text-center">Ảnh</th>
                                            <th class="column-2 text-center">Tên Sản Phẩm</th>
                                            <th class="column-3 text-center">Giá</th>
                                            <th class="column-4 text-center">Số lượng</th>
                                            <th class="column-5 text-center">Thành tiền</th>
                                            <th class=" text-center">Trạng thái</th>
                                            <th>&nbsp;</th>
                                        </tr>

                                    <tr class="table_row">
                                                <td class="column-1">
                                                    <div class="" style="align-items: center;">
                                                        <img style="width: 50px" src="" alt="IMG">
                                                    </div>
                                                </td>
                                                <td class="column-2" style="text-align: center"></td>
                                                <td class="column-3 p-l-10" style="text-align: center"></td>
                                                <td class="column-4">${detail[0].qty}</td>
                                                <td class="column-5"></td>          
                                            </tr>
                                            <tr>
                                    <td colspan="6" class="text-right" style="font-size: 20px; font-weight: bold">Tổng tiền</td>
                                    <td style="color: red;font-size: 20px; font-weight: bold;">
                                        <sup>đ</sup>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>  `



                }
            })
        }
    </script>
@endsection
