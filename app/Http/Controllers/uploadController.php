<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use App\Models\Banner;
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
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'image' => 'required',
       ]);
       if ($validator->fails()){
        return response([
           'message'=>$validator->messages()->first(),
           'status' => false,
       ]);
       }
     $category = Category::create([
         'name' => $request->name,
         'image' => $request->image
     ]);
     return response()->json([
         'status' => true,
         'message' => 'success',
     ]);
 }
 public function postProduct(Request $request){
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'image' => 'required',
        'price' => 'required|max:255',
        'description' => 'required|max:255',
        'header' => 'required|max:255',
       ]);
       if ($validator->fails()){
        return response([
           'message'=>$validator->messages()->first(),
           'status' => false,
       ]);
       }
       $category = Category::where('id',$request->id)->first();
       if($category){
           $product = Products::create([
            'name' => $request->name,
            'image' => $request->image,
            'categoryId' => $category->id,
            'price' => $request->price,
            'description' => $request->description,
            'header' => $request->header,
           ]);
           return response([
            'message'=>'success',
            'status' => true,
        ]); 
       }
       return response([
        'message'=>'faild',
        'status' => false,
    ]);  
}
    public function idProduct(Request $request){
        $product = Products::where('id',$request->id)->first();
        if($product){
            $product = Products::where('id',$request->id)->get();
            return response([
                'data' => $product,
                'message'=>'success',
                'status' => true,
            ]); 
        }
        return response([
            'data' => '',
            'message'=>'faild',
            'status' => false,
        ]);
    
    }
    public function foodMenu(){
        $menu = Products::take(3)->count();
        if($menu){
            $banner = Banner::get();
            $category = Category::get();
            $menu = Products::take(3)->get();
            $sug = Products::take(7)->get();
            $special = Products::take(7)->get();
            return response([
                'data' =>$banner,$category,$menu,$sug,$special,
                'message'=>'success',
                'status' => true,
            ]); 
        }
        return response([
            'data' => '',
            'message'=>'faild',
            'status' => false,
        ]); 
    }
    // public function suggestMenu(){
    //     $menu = Products::take(7)->cont();
    //     if($manu){
    //         $menu = Products::take(7)->get();
    //         return response([
    //             'data' => $menu,
    //             'message'=>'success',
    //             'status' => true,
    //         ]); 
    //     }
    //     return response([
    //         'data' => '',
    //         'message'=>'faild',
    //         'status' => false,
    //     ]); 
    // }
    public function categoryProducts(Request $request){
        $category = Category::where('id',$request->id)->first();
        if($category){
            $product = Category::where('id',$request->id)->has('products')->with('products')->count();
            if($product){
            return response()->json([
                'message' => 'success',
               'data' => $product,
            ],200);
        }}
        return response()->json([
          'message' => 'faild',
        ],404);
    }

 } 

