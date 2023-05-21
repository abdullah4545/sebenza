<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $email=User::where('email', $row[0])->first();
        $phonenumber=User::where('phone', $row[0])->first();
        if($email){

        }elseif($phonenumber){

        }else{

            $memby=User::where('membership_code', $row[0])->first();
            $user=new User();
            $user->first_name=$row[1];
            $user->last_name=$row[2];
            $user->phone=$row[3];
            $user->email=$row[4];
            $user->password=Hash::make($row[9]);
            $user->member_by=$row[0];
            $user->company_name=$row[10];
            $user->country=$row[5];
            $user->city=$row[6];
            $user->address=$row[7];
            $user->assignRole('testRo');
            $user->save();
        }

    }
}
