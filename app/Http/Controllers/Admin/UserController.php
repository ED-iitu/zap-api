<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 23.04.2022
 * Time: 15:17
 */

namespace App\Http\Controllers\Admin;


class UserController
{
    public function index()
    {
        return view('admin.users.index');
    }
}