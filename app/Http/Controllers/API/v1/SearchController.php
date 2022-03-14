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
use Illuminate\Support\Facades\Validator;
use App\Repositories\UsersRepository;

class SearchController extends Controller
{
    public function search(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'vin' => 'required|regex:/^[A-HJ-NPR-Za-hj-npr-z\d]{8}[\dX][A-HJ-NPR-Za-hj-npr-z\d]{2}\d{6}$/|min:17',
            'category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'message' => $validator->errors(),
                'status' => Response::HTTP_BAD_REQUEST
            ];
        }

        $vin        = $request->get('vin');
        $categories = implode(',', $request->get('category_id'));
        $response   = $client->search($vin, $categories);

        return $response;
    }

    public function search2(Request $request, UsersRepository $repository)
    {
        $request->validate(['phone' => 'required']);
        $phone = $request->get('phone');

        $user = $repository->findByPhone($phone);

        $this->updateCodeAndSendSMS($user);

        return [
            'message' => "Sms отправлен на $phone",
            'code' => Response::HTTP_ACCEPTED
        ];
    }
}