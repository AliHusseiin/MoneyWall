<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionAseet extends Model
{
    use HasFactory;
    protected $table = 'transaction_assets';
    protected $guarded = [];
}
