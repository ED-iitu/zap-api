<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 25.11.2021
 * Time: 22:01
 */

namespace App\Http\Controllers\API\v1;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}