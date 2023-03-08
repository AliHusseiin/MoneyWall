<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    //
    
    public function updateMoney(Request $request){
        try{
            $request->validate(Transaction::$rules);
        
            $receiver = Transaction::user($request->sellerID); //receiver => seller
            $sender = Transaction::user($request->buyerID); // sender =>buyer
    
            if($sender['balance']){
                if($sender['balance'] >= $request['balance']){
    
                    $receiver['balance'] += $request->balance;
                    $sender['balance'] -= $request->balance;

                    
                    $transaction = new Transaction();
                    $transaction->fill($request->post());
                    $transaction->save();

                    $receiver->save();
                    $sender->save();

                return response()->json(['status'=>200,'message'=>'success']);
                    
                }
            }
        }
        catch(Exception $e){
            return response()->json(['status'=>400,'message'=>$e->getMessage()]);
        }
        
    }

    public function payBill(Request $request){

        try{
            $request->validate(Transaction::$rules);

            $bill = Transaction::getBill($request->billID);
    
            $user = Transaction::user($request->userID);
            if($user['balance'] >= $bill['balance']){
                $user['balance'] -= $bill['balance'];

                
                $transaction = new Transaction();
                $transaction->fill($request->post());
                $transaction->save();

                $user->save();

                return response()->json(['status'=>200,'message'=>'success']);

            }

        }
        catch(Exception $e)
        {
            return response()->json(['status'=>400,'message'=>$e->getMessage()]);
        }
        
    }

    function transferAssetbetweenUsers(Request $request){
        try
        {
            $request->validate(Transaction::$rules);

        $seller = Transaction::user($request->sellerID);
        $buyer = Transaction::user($request->buyerID);
        $type = $request->type;
        
        switch($type){
            case 'house':
                $house = Transaction::house($request->assetID);
                //remove from seller - add to buyer
                
                break;
            case 'transportation':
                $transportation = Transaction::transportation($request->assetID);
                //remove from seller - add to buyer
                break;
            case 'other':
                $asset = Transaction::other($request->assetID);
                //remove from seller - add to buyer
                break;        
        }

        $transaction = new Transaction();
        $transaction->fill($request->post());
        $transaction->save();

        return response()->json(['status'=>200,'message'=>'success']);
        }
        catch(Exception $e)
        {
        return response()->json(['status'=>400,'message'=>$e->getMessage()]);
        }
        
    }
}
