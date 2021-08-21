<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get and return all customer 
        $customers = Customer::all();

        return view('pages.customer.index')->with('customers', $customers);
    }



    // Get all ajax request and store the record and returns the response
    public function addCustomer(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',

        ]);

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;

        $customer->save();

        // flash message to session
        Session::flash('success', 'Customer added successfully!');

        return response()->json($customer);
    }


    // This method gets the customer by id for edit form
    public function getCustomerById($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }


    // This method Will update the requested ajax update
    public function updateCustomer(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',

        ]);

        $customer = Customer::find($request->id);

        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;

        $customer->save();

        // flash message to session
        Session::flash('success', 'Customer updated successfully!');

        return response()->json($customer);
    }


    // This method will delete the specific record

    public function deleteCustomer($id)
    {
        $customer = Customer::find($id);

        $customer->delete();

        return response()->json(['success' => 'Customer has been deleted']);
    }
}
