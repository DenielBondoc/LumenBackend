<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Origin: http://localhost:4200/'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed


class CustomerController extends Controller
{
    public function showAllCustomers()
    {
        return response()->json(Customer::all());
    }

    public function showOneCustomer($id)
    {
        return response()->json(Customer::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'location' => 'required|alpha'
        ]);


        $customer = Customer::create($request->all());

        return response()->json($customer, 201);
    }

    public function update($id, Request $request)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return response()->json($customer, 200);
    }

    public function delete($id)
    {
        Customer::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
