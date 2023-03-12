<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Mail\PasswordReset;
use App\Models\AssetsTransportation;
use App\Models\PasswordReset as ModelsPasswordReset;
use App\Models\PasswordResetModel;
use App\Models\TransactionAsset;
use App\Models\TransactionMoney;
use App\Models\User;
use App\Models\UserAsset;
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


    
    function changeAssetEquityRequest(Request $request)
    {
           
            if (Auth::user()) {
                $sellerID = Auth::user()->id;
                $buyerEmail = $request->buyerEmail; //selleer send buyer email in the request
                $seller = User::where('id', $sellerID)->first();
                $buyer = User::where('email', $buyerEmail)->first();
                $buyerID = $buyer->id;
                
                $assetTransAction = new TransactionAsset();
                $assetTransAction->type =$request->assetType;
                $assetTransAction->description = $request->description;
                $assetTransAction->assetID = $request->assetID;
                $assetTransAction->sellerID = $sellerID;
                $assetTransAction->buyerID = $buyerID;
                $assetTransAction->amount = $request->amount;
                
                $assetTransAction->save();
                return response()->json(['message' => 'Your Request has been sent to '.$buyerEmail.'!'], 201);
                } 
            else {
                return response()->json(['UnAuthorized'], 401);
            }
                
     }

     function buyerDecisionOnAssetChangeEquityTransAction(Request $request)
     {
        if (Auth::user()) {
             $buyerID = Auth::user()->id;
             $transaction = TransactionAsset::where('buyerID',$buyerID)->first();
             $sellerID = $transaction->sellerID;
             $buyer = User::where('id', $buyerID)->first();
             $seller = User::where('id', $sellerID)->first();
            $assetID = $transaction->assetID;
            $asset = UserAsset::findOrFail($assetID);
            $amount = $transaction->amount;
            $decision = $request->status;
             if(($decision === 'accept' ) && ($buyer->balance >= $amount && $transaction->status === 'pending') )
             {
                $buyer->balance -= $amount;
                $seller->balance += $amount;
                $asset->userID = $buyer->id;
                $transaction->status = 'completed';
                $seller->save();
                $buyer->save();
                $transaction->save();
                $asset->save();
                 return response()->json(['message' => 'Your Have accepted the offer from '.$seller->email.'!'], 200);
             }
             elseif($transaction->status !== 'pending')
             {
                return response()->json(['message' => 'somthing wrong '], 403);

             }
             else {
                $transaction->status = 'rejected';
                $transaction->save();
                 return response()->json(['message' => 'Your Have rejected the offer from '.$seller->email.'!'], 200);
            }

             }

            
    
        else {
            return response()->json(['UnAuthorized'], 401);
            }

        }


     }
         

