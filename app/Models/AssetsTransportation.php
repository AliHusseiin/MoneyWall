<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsTransportation extends Model
{
    use HasFactory;
     protected $table = 'assets_transportation';

     protected $guarded = [];
         public function user_asset(){
        return $this->belongsTo(UserAsset::class);
    }
}
