<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Bill::all();
        return compact("bills");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $users = User::all();
        return compact("users"); 
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $bill = new Bill;
        
     
        // $bill['company_name'] =$request['description'];

        $bill->fill($request->post());
        $bill['company_name'] ="Electricity Bill";
        $bill['amount'] =  200;
        $bill['description'] = "We send text messages to customers to remind them to pay overdue bills. Those text messages will have a reference number. We will also send outage notification texts, but only if you’ve opted in to notifications using your online account.";
        $bill['status'] =  "Required";
        $bill['due_time'] ="2/5/2023";
        $bill['userID '] = 5;

        $bill->save();
        return response()->json(['message' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $Bill)
    {
        //
    }

   
    public function destroy(Bill $Bill)
    {
        //
    }
}
