<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
class UsersController extends Controller
{
    //
    function register(Request $request) {
        $request->validate(User::$rules);
        $user = new User;
        $user->fill($request->post());
        $user['password'] = Hash::make($user['password']);
        $verificationToken = Str::random(100);
        $user->verification_email_token = $verificationToken;
        try{
            $user->save();

            //Send verification email
            $URL = url('http://127.0.0.1:8000/api/user/verify/' . $verificationToken);
            Mail::to($user->email)->send(new EmailVerification($URL));

            return Response::json("User added to DB ", 201);
        }catch(QueryException $e){
            // Checking if user already registered
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return 'Email already signed';
            }
        } 
    }
    function login(Request $request) {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if($user){
            if(Auth::attempt(['email'=>$email,'password'=>$password])){
                if($user->email_verified_at){
                    // Generate an access token, By default, Sanctum sets the expiration time for an access token to one hour (3600 seconds)
                    $accessToken = $user->createToken("API Access Token")->plainTextToken;
            
                    // Generate a refresh token
                    $refreshToken = Str::random(60);

                    // Set the refresh token expiration time
                    $refreshTokenExpiration = Carbon::now()->addDays(7);
                    // Save the refresh token and its expiration time to the database
                    $user->refresh_token = $refreshToken;
                    $user->refresh_token_expiration = $refreshTokenExpiration;
                    $user->save();
                    return response()->json([
                        'status' => true,
                        'message' => 'User Logged In Successfully',
                        'data' => $user,
                        'access_token' => $accessToken,
                        'refresh_token' => $refreshToken
                    ], 200);  
                } else {
                    return Response::json("Please Verify your account, Check junk/spam folder.", 404);
                }
            }else{
                return Response::json("password is incorrect!", 400);
            } 
        }else {
            return Response::json("email is not found!", 404);
        }
    }
    function verifyEmail(Request $request) {
        $user = User::where('verification_email_token', $request->verificationToken)->first();
        if (!$user) {
            return response()->json(['error' => 'Token not found'], 404);
        }
    
        $user->email_verified_at = Carbon::now();
        $user->verification_email_token = null;
        $user->save();
        if($request->wantsJson()) {
            return response()->json(['message' => 'Email verified'], 200);
        }
        return view('email.ConfirmEmail');
    }
}
