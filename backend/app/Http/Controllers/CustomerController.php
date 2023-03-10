<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;



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
            'twitter' => 'required',
            'github' => 'required',
            'latest_article_published' => 'required',
        ]);

        $customer = Customer::create($request->all());

        return response()->json($customer, 201);
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'twitter' => 'required',
            'github' => 'required',
            'latest_article_published' => 'required'
        ]);

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