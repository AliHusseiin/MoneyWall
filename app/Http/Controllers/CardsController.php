<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Carbon\Carbon;
use Date;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;

class CardsController extends Controller
{

    //
    function getCards()
    {
        $cards = Card::all();
        // $card = new Card();
        // $card->CVV = Crypt::encrypt($card['CVV']);

        return response()->json(["status" => 200, "cards" => $cards]);
    }
    function add(Request $request)
    {
        $request->validate(Card::$rules);
        $card = new Card();

        $date2 = Carbon::now()->format('m/y');
        $card->fill($request->post());
        $exp_date = $card->exp_date;
        $date1 = Carbon::createFromFormat('m/y', $exp_date);
        //encrypt
        $card->CVV = Crypt::encrypt($card->CVV);
        $card->card_Number = Crypt::encrypt($card->card_Number);
        $card->exp_date = Crypt::encrypt($card->exp_date);

        //decrypt
        try {
            $cvv = Crypt::decrypt($card->CVV);
            $number = Crypt::decrypt($card->card_Number);
            $exp = Crypt::decrypt($card->exp_date);
        } catch (DecryptException $e) {
            $e->getMessage();
            info("Err=");
        }
        if ($date1->gt($date2)) {
            $card->save();
            return response()->json([
                "status" => true,
                'message' => 'Card added successfully',
                "cvv" => $cvv,
                'number' => $number,
                'exp' => $exp,
                'data' => $card,
            ], 200);
        }
        return Response::json("Expired card", 403);

    }

    public function show($id)
    {
        $card = Card::findOrFail($id);
        $card->CVV = Crypt::encrypt($card['CVV']);
        return response()->json(["status" => 200, "message" => "Cards added!", "card" => $card]);
    }

    public function destroy($id)
    {
        $card = Card::find($id);
        $result = $card->delete();
        if ($result) {
            return (["result" => "deleted!"]);
        } else {
            return (["result" => "faild"]);
        }
    }
}