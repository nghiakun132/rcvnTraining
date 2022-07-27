<?php

namespace App\Exports;

use App\Models\mst_customers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Session;

class CustomersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $name = Session::get('name');
        $status = Session::get('status');
        $email = Session::get('email');
        $address = Session::get('address');
        $customers = mst_customers::limit(10)->select('customer_name', 'email', 'tel_num', 'address')->get();
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
        $customers = $mst_customers->select('customer_name', 'email', 'tel_num', 'address')->get();

        return $customers;
        Session::forget('name');
        Session::forget('status');
        Session::forget('email');
        Session::forget('address');
    }
    public function headings(): array
    {
        return [
            'Tên khách hàng',
            'Email',
            'Điện thoại',
            'Địa chỉ',
        ];
    }
}
