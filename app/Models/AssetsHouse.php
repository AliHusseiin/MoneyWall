<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsHouse extends Model
{
    use HasFactory;

    protected $table = 'assets_housing';

    protected $guarded = [];
       public function user_asset(){
        return $this->belongsTo(UserAsset::class);
    }

      

}
