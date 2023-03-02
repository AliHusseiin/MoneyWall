<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $table = 'bills';
    protected $guarded = [];
    // protected $fillable =[];
//    protected $fillable = ['company_name','amount','description','status','due_time','userID'];

}
