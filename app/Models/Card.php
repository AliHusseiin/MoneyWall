<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Card extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static $rules = [
        'bank_name' => 'required',
        'balance' => 'required',
        'card_Number' => 'required|digits:16',
        'exp_date' => 'required',
        'CVV' => 'required|digits:3',

    ];

}