<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
        $card->fill($request->post());
        $card->CVV = Crypt::encrypt($card['CVV']);
        $card->card_Number = Crypt::encrypt($card['card_Number']);
        $card->exp_date = Crypt::encrypt($card['exp_date']);
        $card->save();
        $cards = Card::all();
        return response()->json(["status" => 200, "message" => "Cards added!", "cards" => $cards]);
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