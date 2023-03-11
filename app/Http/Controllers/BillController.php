<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Response;
class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $bills = Bill::all();
            return response()->json($bills, 200);
        }catch(QueryException $e) {
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }
    public function show($id)
    {
        try {
            $bills = Bill::where('userID', $id)->get();
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
            $bill->due_time =$request->due_time;
            $bill->userID =$request->userID;
            $bill->save();
            return response()->json(['message' => 'success'],201);
        }catch (QueryException $e) {
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }
    function payBill(Request $request) {
        try{
            if(Auth::user()) {
                $billID = $request->billID;
                $bill = Bill::where('id', $billID)->first();
                $userID = Auth::user()->id;
                $user = User::where('id', $userID)->first();
                $userBalance = $user->balance;
                if($userBalance >= $bill->amount) {
                    $user->balance -= $bill->amount;
                    $user->save();
                    $bill->status = "Paid";
                    $bill->save();
                    return response()->json(['message' => 'Bill Paid!'],201);
                } else {
                    return Response::json("User Balance is not sufficient", 400);
                }
            } else {
                return response()->json(['UnAuthorized'], 401);
            }
        } catch(QueryException $e) {
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }
}
