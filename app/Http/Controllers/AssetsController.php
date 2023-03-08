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
        if ($id == Auth::user()->id) {
            $userID = $id;
            $userAllAssets = UserAsset::where('userID', $userID)->with(['other', 'house', 'transportation'])->get();
            $assetOther = [];
            $assetHouse = [];
            $assetTransportation = [];



            foreach ($userAllAssets as $asset) {
                if ($asset->other) {
                    $asset->other->status = $asset->status;
                    array_push($assetOther, $asset->other);
                }
                if ($asset->house) {
                    $asset->house->status = $asset->status;
                    array_push($assetHouse, $asset->house);
                }
                if ($asset->transportation) {
                    $asset->transportation->status = $asset->status;
                    array_push($assetTransportation, $asset->transportation);
                }
            }
            return response()->json(['Other' => $assetOther, 'House' => $assetHouse, 'Transportation' => $assetTransportation]);
        } else
            return response()->json(['UnAuthoized'],401);
            
    }

    function createNewAssets(Request $request)
    {
        if($request->id == Auth::user()->id)
        {
            if ($request['other']) {
                $request->validate(UserAsset::$rules);
                $documentUrl = $request->file('document')->store('user_assets', ['disk' => 'public']);
                $userAsset = new UserAsset;
                $userAsset['userID'] = $request['id'];
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


        if ($request->id == Auth::user()->id) {
            if ($request['realestate']) {
                $request->validate(UserAsset::$rules);
                $documentUrl = $request->file('document')->store('user_assets', ['disk' => 'public']);
                $userAsset = new UserAsset;
                $userAsset['userID'] = $request['id'];
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

        if ($request->id == Auth::user()->id) {
            if ($request['vehicle']) {
                $request->validate(UserAsset::$rules);
                $documentUrl = $request->file('document')->store('user_assets', ['disk' => 'public']);
                $userAsset = new UserAsset;
                $userAsset['userID'] = $request['id'];
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

    function showAllUserAssetsToAdmin(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        if($user->isAdmin)
        {
            $allAssets = UserAsset::all();
            return response()->json(['userAssets'=>$allAssets]);
        }
        else return response()->json(['UnAuthoized'], 403);
    }
   

    function adminDocumentsConfirmation(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        if($user->isAdmin)
        {
            $userAsset = UserAsset::findOrFail($request->assetId);
            $userAsset->status = $request->status;
            $userAsset->save();

            return response()->json(['message'=>'done']);

        }
        else return response()->json(['UnAuthoized'], 403);

    }




 
}
