<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\Product;

class ProdukController extends Controller
{

    public function getProduct($id=null){
        if(empty($id)){
            $users = Product::get();
            return response()->json(["product"=>$users],200);
        }else{
            $users = Product::find($id);
            return response()->json(["product"=>$users],200);
        }
        
    }

    public function addProduk(Request $request){
        if($request->isMethod('post')){
            $userData = $request->input();
            //echo "<pre>"; print_r($userData); die;
            $rules=[
                "name"     => "required|regex:/^[\pL\s\-]+$/u",
                "qty"    => "required",
                "stock" => "required"
            ];
            $customMessage = [
                "name.required"     => "Name is required",
                "qty.required"    => "Qty is required",
                "stock.required" => "Stock is required"
            ];

            $validator = Validator::make($userData,$rules,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),442);
            }
            $user           = new Product;
            $user->name     = $userData['name'];
            $user->qty      = $userData['qty'];
            $user->stock    = $userData['stock'];
            $user->save();
            return response()->json(["message"=>'Produk added success'],201);
        }
    }


    
}
