<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\AssetsHouse;

class Transaction extends Model
{
    use HasFactory;

    public static $rules =[
        'sellerID'=>'required', 
        'buyerID'=>'required',
    ];
    
    public static function user($id){
        $user = User::find($id);
        return $user;
    }
    public static function getBill($id){
        $bill = Bill::find($id);
        return $bill;
    }

    public static function gethouse($id){
        $house = AssetsHouse::find($id);
        return $house;
    }
    public static function getTransportation($id){
        $transportation = AssetsTransportation::find($id);
        return $transportation;
    }
    public static function getAssetFromOther($id){
        $asset = AssetsOther::find($id);
        return $asset;
    }
    
}
