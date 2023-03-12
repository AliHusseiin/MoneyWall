<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Helper;
use App\Models\User;
use App\Models\UserAsset;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HelperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try{
            if (Auth::user()) {
            $countTrans_assets = DB::table('transaction_assets')->count();
            $countTrans_bills = DB::table('transaction_bills')->count();
            $countTrans_money = DB::table('transaction_money')->count();
             $usersCount=User::count(); 
             $billsCount=Bill::count(); 
             $assetsCount=UserAsset::count(); 
            //  $transCount= $countTrans_assets+$countTrans_bills +$countTrans_money;
             
             return response()->json(
                ['usersCount' =>  $usersCount,
                'billsCount' =>   $billsCount,
                'assetsCount' =>   $assetsCount
                // 'transCount' =>   $transCount
                
                ]
                , 200);
             }
        }catch(QueryException $e) {
            return response()->json( 500);
        }

     
         

    }

}
