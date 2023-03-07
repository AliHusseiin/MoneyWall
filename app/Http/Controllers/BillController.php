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
        $userIds =User::all('id');
        return response()->json( $userIds,200);
    }

    public function show($id)
    {
        // $bills =Bill::where('userID', '=',$id);
        $bills =Bill::where('userID', $id)->get();

        return response()->json( $bills,200);
    }


  

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


   

}
