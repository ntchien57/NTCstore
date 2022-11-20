@extends('admin.main')


@section('content')
    <form action="" class="search m-b-30 m-t-10" style=" width: 60%; margin-left: 200px" >
        <input name="key-search" placeholder="Tìm kiếm khách hàng"  class="input-search ">
        <button type="submit" class="btn-search">
            <i class="fa fa-search" style="color: #0c84ff" ></i>
        </button>
        
    </form>
    <table class="table">
        <thead>
        <tr>
            <th style="width: 80px">ID</th>
            <th>Tên Khách Hàng</th>
            <th>Số Điện Thoại</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Ngày Đặt Hàng</th>
            <th>Trạng Thái</th>
            <th>&nbsp;</th>
        </tr>
        </thead>

        <tbody>
        @foreach($customers as $key => $customer)
            <tr>
                <td> {{ $customer->id }}</td>
                <td> {{ $customer->name }}</td>
                <td> {{ $customer->phone }}</td>
                <td> {{ $customer->email }}</td>
                <td> {{ $customer->address }}</td>
                <td>{{ $customer->created_at }}</td>
                <td>{!! \App\Helpers\Helper::activeOrder($customer->active) !!}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="/admin/customers/view/ {{$customer->id}}">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    {!! $customers->links('my-pagination') !!}
@endsection
