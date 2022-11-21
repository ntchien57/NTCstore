<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(){
        return view('admin.user.login',['title' => ' Đăng nhập hệ thống ']);
    }

    public function store(Request $request){
        $this->validate($request,[
            'email' => 'required|email:filter',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $request -> input('email'),
            'password' => $request -> input('password'),
            'level' => '1'
        ])){
            return redirect()->route('admin');

        }else{
            return redirect()->route('login-home');
        }

        Session::flash('error','Tài khoản hoặc mật khẩu không chính xác');
        return  redirect()->back();
    }

    public function show()
    {
        $result = User::orderByDesc('id')
        ->where('level',0)
        ->search()
        ->paginate(9);
        return view('admin.user.list',[
            'title'=>'Danh sách tài khoản người dùng',
            'acounts' => $result
        ]);

    }

    public function showAdmin()
    {
        $result = User::orderByDesc('id')->where('level',1)->get();
        return view('admin.user.listAdmin',[
            'title'=>'Danh sách tài khoản admin',
            'acounts' => $result
        ]);

    }
    

    public function logout()
    {
            Auth::logout();
            return view('admin.user.login',
            [
                'title' => 'Đăng nhập hệ thống'
            ]);
    }

    public function showChangePasswordForm()
    {

        return view('admin.user.changepass',
            [
                'title' => 'Đổi mật khẩu'
            ]);
    }

    public function changePassword(Request $request){

        if (!Auth::attempt([
            'email' => $request->input('email'),
            'password'=> $request->input('current-password')
        ]))
            {
                Toastr::error('Email hoặc mật khẩu không chính xác','Error');
                return redirect()->back();
            }



        if($request->input('current-password') == $request->input('new-password'))
            {
                Toastr::error('Mật khẩu mới phải khác mật khẩu cũ','Error');
                return redirect()->back();
            }
        Auth::user()->update([
            'password'=> bcrypt($request->input('new-password'))
        ]);

        Toastr::success('Đổi mật khẩu thành công','Success');
        return redirect('/admin/users/login');

    }


    public function deleteUser($id){
        $result = User::findOrFail($id);
        $result->update(['active' => 0]);
        Toastr::success('Người dùng đã bị vô hiệu hóa','Success');
         return redirect()->back();
    }

    public function editUser($id){
        $result = User::findOrFail($id);
        $result->update(['active' => 1]);
        Toastr::success('Tài khoản đã được kích hoạt','Success');
         return redirect()->back();
    }

}
