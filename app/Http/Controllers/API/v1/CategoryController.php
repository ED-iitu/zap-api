<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 12.12.2021
 * Time: 00:58
 */

namespace App\Http\Controllers\API\v1;

use App\Services\AutoPartsApiService\Client;

class CategoryController extends Controller
{
    public function categories(Client $client)
    {
        $response = $client->getCategories();

        return response($response);
    }
}
