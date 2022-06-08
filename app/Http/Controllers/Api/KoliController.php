<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\Product;
use App\Models\Koli;
use App\Models\Item;

class KoliController extends Controller
{

    public function getKoli($id=null){
        if(empty($id)){
            $data = [];
            $koli = Koli::get();
            foreach ($koli as $getkoli) {
                $data[] = array(
                    'koli' => $getkoli->koli,
                    'item' => $getkoli->item
                );
            }

            return response()->json($data,200);
        }else{
            $data = [];
            $koli = Koli::orderBy('id', 'desc')->where('id', $id)->get();
            $items = Item::orderBy('id', 'desc')->where('koli_id', $id)->get();
            foreach ($koli as $getkoli) {
                $data[] = array(
                    'email' => $getkoli->email,
                    'koli' => $getkoli->koli,
                    'item' => $items
                );
            }
          
            return response()->json($data,200);
        }
        
    }

    public function addKoli(Request $request){
        if($request->isMethod('post')){
            $koliData = $request->input();
            //echo "<pre>"; print_r($koliData); die;
            $rules=[
                "koli"     => "required|regex:/^[\pL\s\-]+$/u",
                "email"    => "required",
            ];
            $customMessage = [
                "koli.required"     => "koli is required",
                "email.required"    => "email is required",
            ];

            $validator = Validator::make($koliData,$rules,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),442);
            }
            $koli           = new Koli;
            $koli->koli     = $koliData['koli'];
            $koli->email      = $koliData['email'];
            $koli->save();

            foreach ($koliData['item'] as $key => $value){
                $item           = new Item;
                $item->koli_id  = $koli->id; 
                $item->name     = $value['name'];
                $item->qty      = $value['qty'];
                $item->save();
            }
            return response()->json(["message"=>'Koli added success'],201);
        }
    }
    public function updateKoli(Request $request, $id){
        if($request->isMethod('put')){
            $koliData = $request->input();
            //echo "<pre>"; print_r($koliData); die;
            $rules=[
                "koli"     => "required|regex:/^[\pL\s\-]+$/u",
                "email"    => "required",
            ];
            $customMessage = [
                "koli.required"     => "koli is required",
                "email.required"    => "email is required",
            ];

            $validator = Validator::make($koliData,$rules,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),442);
            }
            $koli           =  Koli::findOrFail($id);
            $koli->koli     = $koliData['koli'];
            $koli->email    = $koliData['email'];
            $koli->save();

            $getItem = Item::where('koli_id', $koli->id)->get();
        foreach($getItem as $getItems){
            $getItems->save();
            $getItems->delete();
        }

            foreach ($koliData['item'] as $key => $value){
                $item           = new Item;
                $item->koli_id  = $koli->id; 
                $item->name     = $value['name'];
                $item->qty      = $value['qty'];
                $item->save();
            }
            return response()->json(["message"=>'Koli update success']);
        }
    }


    
}
