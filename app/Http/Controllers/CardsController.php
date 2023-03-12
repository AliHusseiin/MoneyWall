<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;

class CardsController extends Controller
{

    function addCard(Request $request)
    {
        $userID = $request->id;
        $user = User::where('id', $userID)->first();

        if (Auth::check() && Auth::user()->id == $userID) {
            $request->validate(Card::$rules);
            $card = new Card();


            $card->fill($request->post());
            $card->balance = rand(500, 50000);

            //check exp date
            $exp_date = $card->exp_date;
            $date1 = Carbon::createFromFormat('m/y', $exp_date);
            $date2 = Carbon::now()->format('m/y');

            if ($date1->lte($date2)) {
                return Response::json("Expired card", 422);
            }

            //encrypt
            $card->CVV = Crypt::encrypt($card->CVV);
            $card->card_Number = Crypt::encrypt($card->card_Number);
            $card->exp_date = Crypt::encrypt($card->exp_date);
            $user->balance += $card->balance;    // Increase Balance
            $user->save();
            $card->save();

            return response()->json([
                "status" => true,
                'message' => 'Card added successfully',
                'data' => $card,
            ], 200);
        } else {
            return response()->json([
                "Un Authorized!"
            ], 401);
        }
    }

    public function showCardById(Request $request)
    {
        $userID = $request->id;
        // if (Auth::check() && Auth::user()->id == $userID) {
            $cards = Card::all()->where("userID", $userID);
            $allCards = [];
            foreach ($cards as $card) {

                $card['CVV'] = Crypt::decrypt($card->CVV);
                $card['card_Number'] = Crypt::decrypt($card->card_Number);
                $card['exp_date'] = Crypt::decrypt($card->exp_date);
                array_push($allCards, $card);
            }
            return response()->json(["cards" => $allCards]);
        // } else {
            // return response()->json(["Unauthorized"], 401);
        // }
    }

    public function destroy(Request $request, $id)
    {
        $userID = $request->id;
        if (Auth::check() && Auth::user()->id == $userID) {
            $card = Card::find($id);
            $result = $card->delete();
            if ($result)
                return (["result" => "deleted!"]);
        } else {
            return response()->json(["unothourized"], 401);
        }
    }
}