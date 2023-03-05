<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAsset extends Model
{
    use HasFactory;
    protected $table = 'user_assets';

    protected $guarded = [];

     public function user(){
        return $this->belongsTo(User::class);
    }
      public function assets_house(){
        return $this->hasMany(AssetsHouse::class);
    }
     public function assets_transportation(){
        return $this->hasMany(AssetsTransportation::class);
    }
     public function assets_other(){
        return $this->hasMany(AssetsOther::class);
    }

}
