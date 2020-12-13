<?php

namespace App\Classes;

use App\Models\Role;

class RoleClass
{
    private $arRole=[
        'name'=>'admin',
        'super_user'=>true,
        'access_admin_page'=>true,
    ];

    /**
     * @param $request
     * @param $nullRole - логическая переменная, определяет, пуста ли таблица Roles
     * @return array
     */
    public function addRole($request=null, $nullRole)
    {
        if ($nullRole) {
            return Role::create([
                'name'=>$this->arRole['name'],
                'super_user'=>$this->arRole['super_user'],
                'access_admin_page'=>$this->arRole['access_admin_page']
            ]);
        } else {
            return Role::create([
                'name'=>$request['name'],
                'super_user'=>$request['super_user'],
                'access_admin_page'=>$request['access_admin_page']
            ]);
        }
    }
}
