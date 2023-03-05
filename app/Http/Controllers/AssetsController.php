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
    

    foreach ($userAssets as $asset) {
        if ($asset->other) {

            $name = $asset->other->name;
            $description = $asset->other->description;
        } elseif ($asset->house) {

            $location = $asset->house->location;
            $area = $asset->house->area;
        }
    }
      return response()->json(['Other' => ['name' => $name , 'description' => $description], 'House' => ['Location' => $location, 'area' => $area]]);
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
