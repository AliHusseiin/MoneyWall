<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public static $rules = [
        'amount' => 'required|integer',
        'description' => 'required|string',
        'sellerID' => 'required',
        'buyerID' => 'required',
    ];
}
