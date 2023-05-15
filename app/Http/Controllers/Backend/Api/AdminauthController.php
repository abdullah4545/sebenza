<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AdminauthController extends Controller
{
    public function adminstore(Request $request){
        $email=Admin::where('email', $request->email)->first();
        $phonenumber=Admin::where('phone', $request->phone)->first();
        if($email){
            $response = [
                'status' =>false,
                'message' => "Email Already Taken",
                "data"=> [
                    "admin"=>[],
                ]
            ];
            return response()->json($response,201);
        }elseif($phonenumber){
            $response = [
                'status' =>false,
                'message' => "Phone number has Already Taken",
                "data"=> [
                    "admin"=>[],
                ]
            ];
            return response()->json($response,201);
        }else{
            $admin=new Admin();
            $admin->first_name=$request->first_name;
            $admin->last_name=$request->last_name;
            $admin->phone=$request->phone;
            $admin->email=$request->email;
            $admin->password=Hash::make($request->password);
            $admin->status=$request->status;
            $admin->save();
            if($request->roles){
                $admin->assignRole($request->roles);
            }
            $token = $admin->createToken('admin')->plainTextToken;
            $admin->profile=env('PROD_URL').$admin->profile;

            $response=[
                "status"=>true,
                "message"=>"Admin Create Successfully",
                "data"=> [
                    'token' => $token,
                    "admin"=>$admin,
                ]
            ];
            return response()->json($response, 200);
        }
    }

    public function adminlogin(Request $request){
        $admin = Admin::where('email', $request->email)
                    ->first();
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            $error = [
                    "status"=>false,
                    "message"=>"Login failed",
                    "data"=> [
                        'token' => '',
                        "admin"=>[],
                    ]
            ];
            return response()->json($error);
        }

        $admin = Admin::with('roles')->where('id', $admin->id)->first();

        $token = $admin->createToken('admin')->plainTextToken;
        $admin->profile=env('PROD_URL').$admin->profile;

        $response = [
            "status"=>true,
            "message"=>"Login Successfully",
            "data"=> [
                'token' => $token,
                "admin"=>$admin,
            ]
        ];

        return response($response, 201);
    }

    public function admindetails($id){

        $admin = Admin::with('roles')->where('id', $id)->first();
        $admin->profile=env('PROD_URL').$admin->profile;

        $response = [
            "status"=>true,
            "message"=>"Admin Details",
            "data"=> [
                "admin"=>$admin,
            ]
        ];

        return response($response, 201);
    }

    public function adminlogout(Request $request){
        $token = PersonalAccessToken::where('name','admin')->where('tokenable_id', $request->admin_id);
        $token->delete();
        $error = [
            "status"=>true,
            "message" => 'Logout Successfully',
            "data"=> [
                "admin"=>[],
            ]
        ];
        return response()->json($error);
    }

}