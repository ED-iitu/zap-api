<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 28.11.2021
 * Time: 14:29
 */

namespace App\Http\Controllers\API\v1;

use App\Models\Garage;
use App\Repositories\GarageRepository;
use App\Services\AutoPartsApiService\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function garage(Request $request, Client $client, GarageRepository $repository)
    {
        $vin        = request()->vin;
        $categories = implode(',', request()->category_id);

        if (null !== $data = $repository->findByVin($vin)) {
            $response = [
                'garage' => $data
            ];

            return $response;
        }

        $response   = $client->search($vin, $categories);
        $response   = json_decode($response);

        $garageData = [
            'user_id'      => $request->user() ?? 1,
            'vin'          => $vin,
            'mark'         => $response->data->car->mark,
            'model'        => $response->data->car->model,
            'year'         => (int) $response->data->car->year,
            'capacity'     => (float) $response->data->car->capacity,
            'year_created' => date('Y-m-d'),
            'region'       => $response->data->car->region
        ];

        $garageModel = $repository->create($garageData);

        if (!$garageModel instanceof Garage) {
            return response('Ошибка при создании гаража', Response::HTTP_BAD_REQUEST);
        }

        return [
            'garage' => $garageModel
        ];
    }
}
