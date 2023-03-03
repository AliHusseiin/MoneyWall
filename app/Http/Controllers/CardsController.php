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
}