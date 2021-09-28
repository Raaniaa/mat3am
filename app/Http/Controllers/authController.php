<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
class authController extends Controller
{
     //function new register
     public function register(Request $request){
        $validator = Validator::make($request->all(), [
         'name' => 'required|max:255',
         'email' => 'email|max:255|unique:users',
         'password' => 'required|min:3',
         'city' => '',
         'phone' => 'required|max:255',
        ]);
        if ($validator->fails()){
         return response([
            'message'=>$validator->messages()->first(),
            'status' => false,
        ]);
        }
        $request['password']=Hash::make($request['password']);
        $details = User::create([
         'name' => $request->name,
         'phone' => $request->phone,
         'password' => $request->password,
         'email' => $request->email,
         'city' => $request->city,
        ]);
         $token = $details->createToken('auth_token')->plainTextToken;
        return response()->json([
         'message' => "User registered successfully",
         'status' => true,
        ]);
     }
     //function login
     public function login(Request $request){
         
         $loginData = Validator::make($request->all(), [
             'phone' => 'required|max:255',
             'password' => 'required|min:3',
            ]);
            if ($loginData->fails())
            {
                return response([
                    'message'=>$validator->messages()->first(),
                    'status' => false,
                    'data' => '',
                    'access_token' => '',
                ],401);
            }
         $user = User::where('phone', $request['phone'])->first();
         
         if($user){
             //if($user->verified == 0){
                 if (!auth()->attempt($request->only('phone','password'))) {
                   return response([
                    'data' => '',
                    'message' => 'Wrong Password',
                    'status' => false,
                    'access_token' => '',
                ],401);
             }
                 $accessToken = auth()->user()->createToken('auth_token')->plainTextToken;
                 return response([
                    'data' => auth()->user(),
                    'access_token' => $accessToken,
                    'message' => 'success',
                    'status' => true,
                 ],200);
         }
         return response([
            'data' => '',
            'message' => 'phone Wrong please register',
            'status' => false,
            'access_token' => '',
        ],401); 
     }
}
