<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users =User::with('roles')->get();
        $response = [
            'status' => true,
            'message'=>'List of users',
            "data"=> [
                'users'=> $users,
            ]

        ];
        return response()->json($response,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=new User();
        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
        $user->company_name=$request->company_name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->phone=$request->phone;
        $user->save();
        if($request->roles){
            $user->assignRole($request->roles);
        }
        $response=[
            "status"=>true,
            'message' => "User created successfully",
            "data"=> [
                'user'=> $user,
            ]
        ];
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getuserroles()
    {
        $roles =Role::where('guard_name','web')->get();
        $response = [
            'status' => true,
            'message'=>'List of user roles',
            "data"=> [
                'roles'=> $roles,
            ]

        ];
        return response()->json($response,200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles =Role::where('guard_name','web')->get();
        $user =User::with('roles')->where('id',$id)->first();
        $response = [
            'status' => true,
            'message'=>'User By ID',
            "data"=> [
                'roles'=> $roles,
                'user'=> $user,
            ]

        ];
        return response()->json($response,200);
    }

    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $user=User::where('id',$request->user_id);
        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
        $user->company_name=$request->company_name;
        $user->email=$request->email;
        if($request->password){
            $user->password=Hash::make($request->password);
        }
        $user->phone=$request->phone;
        $user->save();
        $user->roles()->detach();
        if($request->roles){
            $user->assignRole($request->roles);
        }

        $response=[
            "status"=>true,
            'message' => "User updated successfully",
            "data"=> [
                'user'=> $user,
            ]
        ];
        return response()->json($response, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id',$id)->first();
        if(is_null($user)){
            $response=[
                "status"=>false,
                'message' => "Something went wrong",
                "data"=> [
                    'user'=> [],
                ]
            ];
            return response()->json($response, 200);
        }else{
            $user->delete();
            $response=[
                "status"=>true,
                'message' => "User Deleted Successfully",
                "data"=> [
                    'user'=> [],
                ]
            ];
            return response()->json($response, 200);
        }
    }

}
