<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Mail\PasswordReset;
use App\Models\PasswordReset as ModelsPasswordReset;
use App\Models\PasswordResetModel;
use App\Models\TransactionAssets;
use App\Models\TransactionBills;
use App\Models\TransactionMoney;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    //
    function sendMoney(Request $request)
    {
        try {
            if (Auth::user()) {

                $senderID = Auth::user()->id;
                $receiverEmail = $request->receiverEmail;
                $sender = User::where('id', $senderID)->first();
                $receiver = User::where('email', $receiverEmail)->first();
                $amount = $request->amount;
                $description = $request->description;
                if ($sender->balance >= $amount) {
                    $sender->balance -= $request->amount;
                    $receiver->balance += $request->amount;
                    $sender->save();
                    $receiver->save();
                    $transaction = new TransactionMoney();
                    $transaction->amount = $amount;
                    $transaction->description = $description;
                    $transaction->senderID = $senderID;
                    $transaction->receiverID = $receiver->id;
                    $transaction->save();
                    return response()->json(['message' => 'Transaction Complete!'], 201);
                } else {
                    return Response::json("You don't have sufficient money to complete this transaction!", 400);
                }
            } else {
                return response()->json(['UnAuthorized'], 401);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }






    public function getTransMoney()
    {

        try{
            if (Auth::user()) {
                $data = TransactionMoney::all();
                return response()->json($data,200);       
                  }
        }catch(QueryException $e) {
            return response()->json( 500);
        }


    }

    public function getTransBills()
    {

        try{
            if (Auth::user()) {
                $data = TransactionBills::all();
                return response()->json($data,200);
             }
        }catch(QueryException $e) {
            return response()->json( 500);
        }


    }








}


