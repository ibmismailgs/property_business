<?php

namespace App\Repositories\Helper;
use Auth;


class ModeDataRepository
{
    /**
     * Display a listing of the resource as role.
     * @return \Illuminate\Http\Response
     */

    public static function allDataAsRole($userRole, $model, $relations = []) {
        //Collect data according to role

        if ($userRole === 'Super Admin') {

            //Super admin can get all data
            $query = $model::query();

        } elseif ($userRole === 'Admin') {

            //auth is admin.admin_id column has all admin id
            $query = $model::where('admin_id', Auth::id());


        } else {

            //auth is not an admin or super admin.created_by column has all current auth id
            $query = $model::where('admin_id', Auth::user()->parent_admin_id);

        }

        $query->with($relations);

        return $query;
    }

    /**
     * Collect count as role
     * @return \Illuminate\Http\Response
     */

    public static function countAsRole($userRole, $model){

        if ($userRole === 'Super Admin') {

            $totalData = $model::count();

        } elseif ($userRole === 'Admin') {

            //admin_id column has main admin id
            $totalData = $model::where('admin_id', Auth::id())
                ->count();

        } else {

            //created_by column has main current user id
            $totalData = $model::where('created_by', Auth::id())
                ->count();
        }

        return $totalData;
    }

}
