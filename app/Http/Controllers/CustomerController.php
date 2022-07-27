<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Imports\CustomersImport;
use App\Models\mst_customers;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = mst_customers::all();
        return view('customer.index', compact('customers'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:mst_customers,email',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required',

        ], [
            'name.required' => 'Vui lòng nhập tên khách hàng',
            'name.min' => 'Tên khách hàng phải lớn hơn 5 ký tự',
            'email.required' => 'Email không thể bỏ trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được đăng ký',
            'phone.required' => 'Điện thoại không thể bỏ trống',
            'phone.numeric' => 'Điện thoại phải là số',
            'phone.digits' => 'Điện thoại phải có 10 số',
            'address.required' => 'Địa chỉ không thể bỏ trống',
        ]);
        $customer = new mst_customers();
        $customer->customer_name = $request->name;
        $customer->email = $request->email;
        $customer->tel_num = $request->phone;
        $customer->address = $request->address;
        if ($request->status == 'on') {
            $customer->is_active = 1;
        } else {
            $customer->is_active = 0;
        }
        $customer->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $customer->save();
        return redirect()->route('customers')->with('success', 'Thêm khách hàng thành công');
    }
    public function destroy($id)
    {
        $customer = mst_customers::where('customer_id', $id)->first();
        $customer->delete();
        return redirect()->route('customers')->with('success', 'Xóa khách hàng thành công');
    }
    public function search(Request $request)
    {
        $name = $request->input('name');
        $status = $request->input('status');
        $email = $request->input('email');
        $address = $request->input('address');
        Session::put('name', $name);
        Session::put('status', $status);
        Session::put('email', $email);
        Session::put('address', $address);
        $mst_customers = new mst_customers();
        if ($name != '' && !is_null($name)) {
            $mst_customers = $mst_customers->where('customer_name', 'like', '%' . $name . '%');
        }

        if ($status != '' && !is_null($status)) {
            $mst_customers = $mst_customers->where('is_active', $status);
        }

        if ($email != '' && !is_null($email)) {
            $mst_customers = $mst_customers->where('email', 'like', '%' . $email . '%');
        }

        if ($address != '' && !is_null($address)) {
            $mst_customers = $mst_customers->where('address', 'like', '%' . $address . '%');
        }
        $customers = $mst_customers->get();
        return view('customer.index', compact('customers'));
    }

    public function importCustomer(Request $request)
    {
        Excel::import(new CustomersImport,  $request->file('file'));
        return redirect()->back()->with('success', 'User Imported Successfully.');
    }
    public function exportCustomer()
    {
        return Excel::download(new CustomersExport, 'customer.xlsx');
    }
    public function edit()
    {
        $customers = mst_customers::all();
        return view('customer.index', compact('customers'));
    }
    public function update(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'edit') {
                DB::table('mst_customers')->where('customer_id', intval($request->customer_id))->update([
                    'customer_name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                    'tel_num' => $request->tel_num,
                    'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                ]);
            }
            if ($request->action == 'delete') {
                DB::table('mst_customers')
                    ->where('customer_id', $request->customer_id)
                    ->delete();
            }
            return response()->json($request);
        }
    }
}
