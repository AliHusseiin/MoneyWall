<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsOther extends Model
{
    use HasFactory;
     protected $table = 'assets_other';

    protected $guarded = [];
         public function user_asset(){
        return $this->belongsTo(UserAsset::class);
    }
}
