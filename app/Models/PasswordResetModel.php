<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetModel extends Model
{
    use HasFactory;
    protected $table = 'password_reset_tokens';
    protected $guarded = [];
    protected $primaryKey = 'token';
    public $incrementing = false;
}
