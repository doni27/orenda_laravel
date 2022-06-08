<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class UserController extends Controller
{

    public function getUsers($id=null){
        if(empty($id)){
            $users = User::get();
            return response()->json(["users"=>$users],200);
        }else{
            $users = User::find($id);
            return response()->json(["users"=>$users],200);
        }
        
    }

    public function addUser(Request $request){
        if($request->isMethod('post')){
            $userData = $request->input();

            $rules=[
                "name"     => "required|regex:/^[\pL\s\-]+$/u",
                "email"    => "required|email|unique:users",
                "password" => "required"
            ];
            $customMessage = [
                "name.required"     => "Name is required",
                "email.required"    => "Email is required",
                "email.email"       => "Valid email is required",
                "email.unique"      => "Email already exists in database",
                "password.required" => "Password is required"
            ];

            $validator = Validator::make($userData,$rules,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),442);
            }
            $user           = new User;
            $user->name     = $userData['name'];
            $user->email    = $userData['email'];
            $user->password = bcrypt($userData['name']);
            $user->save();
            return response()->json(["message"=>'User added success'],201);
          

        }
    }
    public function addMultipleUsers(Request $request){
        if($request->isMethod('post')){
            $userData       = $request->input();
              //cek post 
            //  echo "<pre>"; print_r($userData); die;
            $rules=[
                "users.*.name"     => "required|regex:/^[\pL\s\-]+$/u",
                "users.*.email"    => "required|email|unique:users",
                "users.*.password" => "required"
            ];
            $customMessage = [
                "name.required"     => "Name is required",
                "email.required"    => "Email is required",
                "email.email"       => "Valid email is required",
                "email.unique"      => "Email already exists in database",
                "password.required" => "Password is required"
            ];

           
            $validator = Validator::make($userData,$rules,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),442);
            }
            foreach ($userData['users'] as $key => $value){
            $user           = new User;
            $user->name     = $value['name'];
            $user->email    = $value['email'];
            $user->password = bcrypt($value['name']);
            $user->save();
            return response()->json(["message"=>'User added success'],201);
        }

        }
    }
    
}
