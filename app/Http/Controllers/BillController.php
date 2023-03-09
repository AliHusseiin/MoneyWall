<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $userIds = User::all('id');
            return response()->json($userIds, 200);
        }catch(QueryException $e) {
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }
    public function show($id)
    {
        try{
            $bills =Bill::where('userID', $id)->get();
            return response()->json( $bills,200);
        } catch(QueryException $e) {
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }
    public function addBill(Request $request)
    {
        try{
            $bill = new Bill;
            $bill->company_name =$request->company_name;
            $bill->type=$request->type;
            $bill->amount = $request->amount;
            $bill->description = $request->description;
            $bill->status = $request->status;
            $bill->due_time =$request->due_time;
            $bill->userID =$request->userID;
            $bill->save();
            return response()->json(['message' => 'success'],201);
        }catch (QueryException $e) {
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }
}
