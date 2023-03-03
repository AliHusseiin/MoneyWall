<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    //
    function getCards()
    {
        $cards = Card::all();
        return response()->json(["status" => 200, "cards" => $cards]);
    }
    function add(Request $request)
    {

        $card = new Card();
        $card->fill($request->post());
        $card->save();
        $cards = Card::all();
        return response()->json(["status" => 200, "message" => "Cards added!", "cards" => $cards]);
    }
}