<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Mail\PasswordReset;
use App\Models\PasswordReset as ModelsPasswordReset;
use App\Models\PasswordResetModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
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
            $existingUser = User::where('username', $user->username)->first();
            if ($existingUser) {
                return Response::json("Username already exists", 409);
            }
            $user->save();
            //Send verification email
            $URL = url('http://127.0.0.1:8000/api/user/verify/' . $verificationToken);
            Mail::to($user->email)->send(new EmailVerification($URL));
            return Response::json("Activation Email has been sent to you.", 201);
        }catch(QueryException $e){
            // Checking if user already registered
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return Response::json("Email already registered", 409);
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
               } 
                else {
                    return Response::json("Please Verify your account, Check junk/spam folder.", 404);
                }
            }else{
                return Response::json("Password is incorrect!", 400);
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
    function refresh(Request $request){
        $refreshToken = $request->refresh_token;

        $user = User::where('refresh_token', $refreshToken)
                    ->where('refresh_token_expiration', '>', Carbon::now())
                    ->first();
    
        if (!$user) {
            return response()->json(['error' => 'Refresh token is invalid or has expired'], 400);
        }
    
        // Generate a new access token
        $accessToken = $user->createToken("API Access Token")->plainTextToken;
    
        // Update the refresh token and its expiration time
        $refreshToken = Str::random(60);
        $refreshTokenExpiration = Carbon::now()->addDays(7);
        $user->refresh_token = $refreshToken;
        $user->refresh_token_expiration = $refreshTokenExpiration;
        $user->save();
    
        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'refresh_token_expiration' => $refreshTokenExpiration
        ], 200);
    }

    function resetPasswordRequest(Request $request) {
        $email = $request->email;
        try{
            $user = User::where('email', $email)->first();
            if ($user) {
                $resetToken = Str::random(60);
                $passwordReset = new PasswordResetModel;
                $passwordReset->email = $request->email;
                $passwordReset->token = $resetToken;
                $passwordReset->expires_at = Carbon::now()->addMinutes(60);
                $passwordReset->save();
                $userFirstName = $user->fname;
                $userLastName = $user->lname;
                $URL = url('http://localhost:4200/reset-password/confirm') . '?token=' . urlencode($resetToken);
                Mail::to($user->email)->send(new PasswordReset($URL, $userFirstName, $userLastName));
                return Response::json("Password reset mail sent successfully.", 201);
            }else {
                return Response::json("Email was not found", 400);
            }
        }catch(QueryException $e) {
            return Response::json("An error occurred while processing your request.", 500);
        }
    }
    function resetPassword(Request $request) {
        $resetToken = $request->token;
        $password = $request->password;
        $tokenRecord = PasswordResetModel::where('token', '=', $resetToken)->first();
        $email = $tokenRecord->email;
        if (!$tokenRecord || Carbon::parse($tokenRecord->expires_at)->isPast()) {
            return Response::json("token is expired or have been used!", 400);
        }
        try {
            $user = User::where('email', $email)->first();
            if(Hash::check($password, $user->password)) {
                return Response::json("New password can not be the same as your old password", 409);
            }else {
                $user->password = $password;
                $user['password'] = Hash::make($user['password']);
                $user->save();
                $tokenRecord->expires_at = Carbon::now();
                $tokenRecord->save();
                return response()->json("Password Updated Successfully", 201);
            }
        }catch(QueryException $e) {
            return Response::json("$e", 500);
        }
    }
    function updateProfile($id,Request $request)
    {


        try{
        $user = User::find($id); 
        $user->fname =$request->firstName;
        $user->lname =$request->lastName;
        $user->username =$request->userName;
        $user->mobile =$request->mobileNum;
        $user->birthday =$request->birthday;
        $user->zip =$request->zip;
        $user->address =$request->address;
        $user->city=$request->city;
        $user->country =$request->state;        
        $user->save();
        return response()->json("You have successfully updated your profile",200);
    }catch(QueryException $e){
        return Response::json("Failed to update your profile", 400);

    } 

    }




    function changePassword($id,Request $request)
    {

         try{ 
          #Match The Old Password
          if(!Hash::check($request->oldPassword, auth()->user()->password)){
           return response()->json("Password is not correct",400);
           }else{
               #Update the new Password
               if($request->newPassword===$request->confirmPassword){
         
                   User::whereId($id)->update([
                       'password' => Hash::make($request->newPassword)
                   ]);   
                return Response::json("Your password has been changed successfully", 200);
         
               }
               else{
                   return Response::json("Please, make sure your passwords match", 400);
               }
           }
           }catch(QueryException $e){
               return Response::json("Failed to change your password", 400);
           } 
         
    }


    function deleteAccount($id,Request $request)
    { 

        
        if  ( Hash::check($request->password, auth()->user()->password )
             && ($request->email== auth()->user()->email ) ){
                  User::destroy($id);
                  return response()->json("Your account deleted successfully",200);

            }else{
                return response()->json("Password is not correct",400);
        
            }
        }


}
