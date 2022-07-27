<?php

namespace App\Http\Controllers;

use App\Models\mst_users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;

class UserController extends Controller
{
    public function index()
    {
        $users = mst_users::where('isDelete', 0)->get();
        return view('user.index', compact('users'));
    }
    public function login()
    {
        return view('user.login');
    }
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống'
        ]);
        $email = $request->email;
        $password = $request->password;
        $user = mst_users::where('email', $email)->where('isActive', 1)->first();
        if ($user) {
            if ((Hash::check($password, $user->password))) {
                Session::put('user', $user->id);
                if ($request->remember == 'on') {
                    mst_users::where('email', $email)->update(['remember_token' => Session::get('user')]);
                }
                mst_users::where('email', $email)->update(['last_login_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
                mst_users::where('email', $email)->update(['last_login_ip' => $request->ip()]);
                return redirect()->route('products');
            } else {
                return redirect()->back()->with('error', 'Mật khẩu không đúng');
            }
        } else {
            return redirect()->back()->with('error', 'Email không tồn tại hoặc bị khóa');
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:mst_users,email',
            'password' => ['required', 'min:5', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
            'confirm' => 'required|same:password'
        ], [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên phải có ít nhất 5 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 5 ký tự',
            'password.regex' => 'Mật khẩu không được bảo mật',
            'confirm.required' => 'Mật khẩu không được để trống',
            'confirm.same' => 'Mật khẩu không trùng khớp'
        ]);
        $user = new mst_users();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($request->status == 'on') {
            $user->isActive = 1;
        } else {
            $user->isActive = 0;
        }
        $user->group_role = $request->group;
        $user->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $user->save();
        return redirect()->back()->with('success', 'Thêm thành công');
    }
    public function destroy($id)
    {
        mst_users::where('id', $id)->update(['isDelete' => 1]);
        return redirect()->back()->with('success', 'Xóa thành công');
    }
    public function active($id)
    {
        $user =  mst_users::where('id', $id)->first();
        if ($user->isActive == 1) {
            mst_users::where('id', $id)->update(['isActive' => 0]);
        } else {
            mst_users::where('id', $id)->update(['isActive' => 1]);
        }
        return redirect()->back()->with('success', 'Xử lý thành công');
    }
    public function search(Request $request)
    {
        // $name = $_GET['name'];
        // $email = $_GET['email'];
        // $group = $_GET['group'];
        // $status = $_GET['status'];
        // if ($name != '' && $email != '' && $group != '' && $status != '') {
        //     $users = mst_users::where('name', 'like', '%' . $name . '%')->where('email', 'like', '%' . $email . '%')->where('group_role', $group)->where('isActive', $status)->get();
        // } elseif ($name != '' && $email != '' && $group != '' && $status == '') {
        //     $users = mst_users::where('name', 'like', '%' . $name . '%')->where('email', 'like', '%' . $email . '%')->where('group_role', $group)->get();
        // } elseif ($name != '' && $email != '' && $group == '' && $status != '') {
        //     $users = mst_users::where('name', 'like', '%' . $name . '%')->where('email', 'like', '%' . $email . '%')->where('isActive', $status)->get();
        // } elseif ($name != '' && $email == '' && $group != '' && $status != '') {
        //     $users = mst_users::where('name', 'like', '%' . $name . '%')->where('group_role', $group)->where('isActive', $status)->get();
        // } elseif ($name != '' && $email != '' && $group == '' && $status == '') {
        //     $users = mst_users::where('name', 'like', '%' . $name . '%')->where('email', 'like', '%' . $email . '%')->get();
        // } elseif ($name != '' && $email == '' && $group == '' && $status != '') {
        //     $users = mst_users::where('name', 'like', '%' . $name . '%')->where('isActive', $status)->get();
        // } elseif ($name == '' && $email != '' && $group != '' && $status != '') {
        //     $users = mst_users::where('email', 'like', '%' . $email . '%')->where('group_role', $group)->where('isActive', $status)->get();
        // } elseif ($name == '' && $email != '' && $group == '' && $status != '') {
        //     $users = mst_users::where('email', 'like', '%' . $email . '%')->where('isActive', $status)->get();
        // } elseif ($name == '' && $email == '' && $group != '' && $status != '') {
        //     $users = mst_users::where('group_role', $group)->where('isActive', $status)->get();
        // } elseif ($name == '' && $email == '' && $group == '' && $status != '') {
        //     $users = mst_users::where('isActive', $status)->get();
        // } elseif ($name != '' && $email == '' && $group == '' && $status == '') {
        //     $users = mst_users::where('name', 'like', '%' . $name . '%')->get();
        // } elseif ($name == '' && $email != '' && $group == '' && $status == '') {
        //     $users = mst_users::where('email', 'like', '%' . $email . '%')->get();
        // } elseif ($name == '' && $email == '' && $group != '' && $status == '') {
        //     $users = mst_users::where('group_role', $group)->get();
        // } elseif ($name == '' && $email == '' && $group == '' && $status != '') {
        //     $users = mst_users::where('isActive', $status)->get();
        // } else {
        //     $users = [];
        // }
        // return view('user.index', compact('users'));
        $name = $request->input('name');
        $email = $request->input('email');
        $group = $request->input('group');
        $status = $request->input('status');
        $mst_users = new mst_users();
        if ($name != '' && !is_null($name)) {
            $mst_users = $mst_users->where('name', 'like', '%' . $name . '%');
        }
        if ($status != '' && !is_null($status)) {
            $mst_users = $mst_users->where('isActive', $status);
        }
        if ($email != '' && !is_null($email)) {
            $mst_users = $mst_users->where('email', 'like', '%' . $email . '%');
        }
        if ($group != '' && !is_null($group)) {
            $mst_users = $mst_users->where('group_role', $group);
        }
        $users = $mst_users->get();
        return view('user.index', compact('users'));
    }
    public function logout()
    {
        $user = Session::get('user');
        Session::forget('user');
        return redirect()->route('login');
    }
    public function update(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'edit') {
                DB::table('mst_users')->where('id', intval($request->id))->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'group_role' => $request->group,
                    'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                ]);
            }
            if ($request->action == 'delete') {
                DB::table('mst_users')
                    ->where('id', $request->id)
                    ->delete();
            }
            return response()->json($request);
        }
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|',
            'new_password_confirmation' => 'required|same:new_password',
        ], [
            'old_password.required' => 'Bạn chưa nhập mật khẩu cũ',
            'new_password.required' => 'Bạn chưa nhập mật khẩu mới',
            'new_password_confirmation.required' => 'Bạn chưa nhập lại mật khẩu mới',
            'new_password_confirmation.same' => 'Mật khẩu mới không trùng khớp',
        ]);
        $user = mst_users::where('id', Session::get('user'))->first();
        if (Hash::check($request->old_password, $user->password)) {
            mst_users::where('id', Session::get('user'))->update([
                'password' => Hash::make($newPassword),
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            ]);
            return redirect()->back()->with('success', 'Đổi mật khẩu thành công');
        } else {
            return redirect()->back()->with('error', 'Mật khẩu cũ không đúng');
        }
    }
}
