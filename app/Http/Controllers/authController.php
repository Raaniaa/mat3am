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
       // $request['email_verification_token'] = Str::random(32);
        $request['password']=Hash::make($request['password']);
        $details = User::create([
         'name' => $request->name,
         'phone' => $request->phone,
         'password' => $request->password,
         'email' => $request->email,
         'city' => $request->city,
        ]);
         $token = $details->createToken('auth_token')->plainTextToken;
        // $verifyUser = VerifyUser::create([
        //  'user_id' => $details->id,
        //  'token' => mt_rand(100000, 999999),
        // ]);
        $user = User::where('id',$details->id)->select('id')->first();
       // \Mail::to($details->email)->send(new MyTestMail($details));
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
             return response(['errors'=>$loginData->errors()->all()], 422);
            }
         $user = User::where('phone', $request['phone'])->first();
         if($user){
             //if($user->verified == 0){
                 if (!auth()->attempt($request->only('phone','password'))) {
                   return response(['message' => 'Wrong Password'], 401);
                 //}
             }
            //  if($user->verified != 0){
            //      if (!auth()->attempt($loginData)) {
            //          return response(['message' => 'Wrong Password'], 401);
            //      } 
                 $accessToken = auth()->user()->createToken('auth_token')->plainTextToken;
                 return response(['user' => auth()->user(), 'access_token' => $accessToken]);
             //}
            //$accessToken = auth()->user()->createToken('auth_token')->plainTextToken;
            //return response(['user' => auth()->user(), 'access_token' => $accessToken]);
            //return response(['message' => 'account not verify'], 400); 
         }
         return response(['message' => 'phone Wrong please register'], 404); 
     }
}
