<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class uploadController extends Controller
{
    public function uploadsImage(Request $request){
        $hospitalRequest = $request->file;
        $image = $request->file('file');
        if($request->file){
            $input = $hospitalRequest = $image->getClientOriginalName();
            $destinationPath = public_path('uploads/');
            $image->move($destinationPath, $input);
            return response()->json([
                'data' => asset('uploads/'.$input),
                'status' => true,
                'message' => 'success Message'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'error message',
        ]);
 }
 public function postCategory(Request $request){
     $category = Category::create([
         'name' => $request->name,
         'image' => $request->image
     ]);
     return response()->json([
         'status' => true,
         'message' => 'success',
     ]);
 }

}