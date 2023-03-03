<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static $rules = [
        'bank_name' => 'required',
        'balance' => 'required',
        'card_Number' => 'required',
        'exp_date' => 'required',
        'CVV' => 'required|max:3'
    ];

}