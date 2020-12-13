<?php

namespace App\Classes;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isNull;

class Registration
{
    static function addUser($request)
    {
        return User::create([
            'name'=>$request['login'],
            'email'=>$request['email'],
            'password'=>Hash::make($request['password']),
        ]);
    }

    /**
     * @param null $id - ID роли
     * @param $request
     */
    static function setUserRole($id=null,$request)
    {
        if (!is_null($id)) {
            $user=self::addUser($request);

            $user->roles()->attach($id);
        } else {
            $user=self::addUser($request);

            $role=new RoleClass();
            $user->roles()->attach($role->addRole(null,true)->id);
        }
    }
}
