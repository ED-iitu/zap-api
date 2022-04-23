<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 23.04.2022
 * Time: 15:07
 */

namespace App\Http\Controllers\Admin;


class ProductController
{
    public function index()
    {
        return view('admin.products.index');
    }
}