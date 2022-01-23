<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 23.01.2022
 * Time: 15:42
 */

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\AutoPartsApiService\Client;

class SearchController extends Controller
{
    public function __construct()
    {
        \request()->headers->set('Content-Type', 'application/json');
    }

    public function search(Request $request, Client $client)
    {
        $vin        = $request->get('vin');
        $categories = implode(',', $request->get('category_id'));
        $response   = $client->search($vin, $categories);

        return response($response);
    }
}