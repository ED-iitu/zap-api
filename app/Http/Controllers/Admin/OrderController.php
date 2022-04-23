<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 23.04.2022
 * Time: 15:18
 */

namespace App\Http\Controllers\Admin;


class OrderController
{
    public function index()
    {
        return view('admin.orders.index');
    }
}