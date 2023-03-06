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
    public function addBill(Request $request)
    {
        
        $bill = new Bill;
        $bill->company_name =$request->company_name;
        $bill->type=$request->type;
        $bill->amount = $request->amount;
        $bill->description = $request->description;
        $bill->status = $request->status;
        $bill->due_time =$request->due_time;
        $bill->userID =$request->userID;
        $bill->save();
        return response()->json(['message' => 'success'],200);
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
