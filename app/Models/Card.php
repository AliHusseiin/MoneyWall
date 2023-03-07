<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;


class Card extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static $rules = [
        'bank_name' => 'required',
        'card_Number' => 'required|digits:16',
        'exp_date' => 'required',
        'CVV' => 'required|digits:3',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}