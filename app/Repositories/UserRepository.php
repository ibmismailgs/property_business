<?php

namespace App\Repositories;

use App\Models\User;
use Auth;

class UserRepository
{

    public static function authRole()
    {
        $userRole = Auth::user()->roles->first()->name;
        return $userRole;
    }

    public static function userRole($id)
    {
        $user = User::findOrFail($id);
        $userRole =$user->roles->first()->name;
        return $userRole;
    }

    public static function authParentId()
    {

        $userRole = self::authRole();

        //Set parent admin id
        if ($userRole == 'Super Admin') {

            $parentAdminId = 1;

        } elseif ($userRole == 'Admin') {

            //set admin id as own id if auth's role is admin
            $parentAdminId = Auth::id();

        } else {

            //set admin id as its parent id if auth's role is not and admin or super admin
            $parentAdminId = Auth::user()->parent_admin_id ?? 1;
        }

        return $parentAdminId;

    }

}
