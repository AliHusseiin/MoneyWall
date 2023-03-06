<?php

namespace App\Http\Controllers;

use App\Models\AssetsHouse;
use App\Models\AssetsOther;
use App\Models\AssetsTransportation;
use App\Models\User;
use App\Models\UserAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetsController extends Controller
{
    //

    function getUserAssets(Request $request)
    {
        $id = $request['id'];
        $userID = $id; 
        $userAssets = UserAsset::where('userID', $userID)->with(['other', 'house', 'transportation'])->get();
        $assetOther = [];
        $assetHouse = [];
        $assetTransportation = [];
    

    foreach ($userAssets as $asset)
     {
        if ($asset->other)
         {
           array_push($assetOther,$asset->other); 
        }
         if ($asset->house)
         {
            array_push($assetHouse,$asset->house); 
        }
        if($asset->transportation)
        {
            array_push($assetTransportation,$asset->transportation); 
        }
    }
      return response()->json(['Other' =>$assetOther, 'House' => $assetHouse, 'Transportation'=>$assetTransportation]);
            
    }

    function createNewAssets(Request $request)
    {
        if ($request['other']) {
            $assetOther = new AssetsOther;
            $userAsset = new UserAsset;
            $userAsset['userID'] = $request['id'];
            $userAsset->save();
            $assetOther->fill($request->post());
            $assetOther['assetID'] = $userAsset['id'];
            $assetOther->save();

            return response()->json(['message' => 'Done']);
        }
        if($request['realestate'])
        {
            $assetRealEstate = new AssetsHouse;
            $userAsset = new UserAsset;
            $userAsset['userID'] = $request['id'];
            $userAsset->save();
            $assetRealEstate->fill($request->post());
            $assetRealEstate['assetID'] = $userAsset['id'];
            $assetRealEstate->save();
            return response()->json(['message' => 'Done']);

        }
         if($request['vehicle'])
        {
            $assetvehicle = new AssetsTransportation;
            $userAsset = new UserAsset;
            $userAsset['userID'] = $request['id'];
            $userAsset->save();
            $assetvehicle->fill($request->post());
            $assetvehicle['assetID'] = $userAsset['id'];
            $assetvehicle->save();
            return response()->json(['message' => 'Done']);

        }
    }




 
}
