<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAsset extends Model
{
    use HasFactory;

    public static $rules = [
        
        'document'  => 'required|mimes:doc,docx,pdf,txt,csv|max:2048'
    ];
    protected $table = 'user_assets';

    protected $guarded = [];

    public function other()
    {
        return $this->hasOne('App\Models\AssetsOther', 'assetID');
    }

    public function house()
    {
        return $this->hasOne('App\Models\AssetsHouse', 'assetID');
    }

    public function transportation()
    {
        return $this->hasOne('App\Models\AssetsTransportation', 'assetID');
    }
}
