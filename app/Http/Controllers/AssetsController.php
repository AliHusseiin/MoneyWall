<?php

namespace App\Http\Controllers;

use App\Models\AssetsHouse;
use App\Models\AssetsOther;
use App\Models\AssetsTransportation;
use App\Models\User;
use App\Models\UserAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
class AssetsController extends Controller
{
    //

    function getUserAssets()
    {
        try{
            if (Auth::user()) {
                $userID = Auth::user()->id;
                $userAllAssets = UserAsset::where('userID', $userID)->with(['other', 'house', 'transportation'])->get();
                $assetsOther = [];
                $assetsRealEstates = [];
                $assetVehicles = [];
                foreach ($userAllAssets as $asset) {
                    if ($asset->other) {
                        $asset->other->status = $asset->status;
                        array_push($assetsOther, $asset->other);
                    }
                    if ($asset->house) {
                        $asset->house->status = $asset->status;
                        array_push($assetsRealEstates, $asset->house);
                    }
                    if ($asset->transportation) {
                        $asset->transportation->status = $asset->status;
                        array_push($assetVehicles, $asset->transportation);
                    }
                }
                return response()->json(['Other' => $assetsOther, 'Real-Estates' => $assetsRealEstates, 'Vehicles' => $assetVehicles]);
            } else {
                return response()->json(['UnAuthoized'], 401);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }

    function createNewAssets(Request $request)
    {
        if(Auth::user())
        {
            if ($request['other']) {
                $request->validate(UserAsset::$rules);
                $documentUrl = $request->file('document')->store('user_assets', ['disk' => 'public']);
                $userAsset = new UserAsset;
                $userAsset['userID'] = Auth::user()->id;
                $userAsset['document'] = $documentUrl;
                $userAsset->save();
                $assetOther = new AssetsOther;
                $assetOther->fill($request->post());
                $assetOther['assetID'] = $userAsset['id'];
                $assetOther->save();
                return response()->json(['message' => 'Done']);
            } 
        }
        else return response()->json(['UnAuthoized'], 401);
        if (Auth::user()) {
            if ($request['realestate']) {
                $request->validate(UserAsset::$rules);
                $documentUrl = $request->file('document')->store('user_assets', ['disk' => 'public']);
                $userAsset = new UserAsset;
                $userAsset['userID'] = Auth::user()->id;
                $userAsset['document'] = $documentUrl;
                $userAsset->save();
                $assetRealEstate = new AssetsHouse;
                $assetRealEstate->fill($request->post());
                $assetRealEstate['assetID'] = $userAsset['id'];
                $assetRealEstate->save();
                return response()->json(['message' => 'Done']);
            }
        }
         else return response()->json(['UnAuthoized'], 401);
        if (Auth::user()) {
            if ($request['vehicle']) {
                $request->validate(UserAsset::$rules);
                $documentUrl = $request->file('document')->store('user_assets', ['disk' => 'public']);
                $userAsset = new UserAsset;
                $userAsset['userID'] = Auth::user()->id;
                $userAsset['document'] = $documentUrl;
                $userAsset->save();
                $assetvehicle = new AssetsTransportation;
                $assetvehicle->fill($request->post());
                $assetvehicle['assetID'] = $userAsset['id'];
                $assetvehicle->save();
                return response()->json(['message' => 'Done']);
            }
        }
        else return response()->json(['UnAuthoized'], 401);
    }

    function showAllUserAssetsToAdmin()
    {
        try{
            if (Auth::user()) {
                $allAssets = UserAsset::all();
                return response()->json(['userAssets' => $allAssets]);
            }
        } catch(QueryException $e) {
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        } 
    }

    function adminDocumentsConfirmation(Request $request)
    {
        try {
            if (Auth::user()) {
                $userAsset = UserAsset::findOrFail($request->assetId);
                $userAsset->status = $request->status;
                $userAsset->save();
                return response()->json(['message' => 'done']);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }
}
