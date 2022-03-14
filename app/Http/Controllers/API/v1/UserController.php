<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 28.11.2021
 * Time: 14:29
 */

namespace App\Http\Controllers\API\v1;

use App\Models\Address;
use App\Models\Garage;
use App\Repositories\GarageRepository;
use App\Services\AutoPartsApiService\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function garage(Request $request, Client $client, GarageRepository $repository)
    {
        $vin         = $request->get('vin');
        $categories  = implode(',', $request->get('category_id'));

        if (null !== $data = $repository->findByVin($vin)) {
            $response = [
                'garage' => $data
            ];

            return $response;
        }

        $response   = $client->search($vin, $categories);
        $response   = json_decode($response);
        $garageData = [
            'user_id'      => $request->user()->id ?? 1,
            'vin'          => $vin,
            'mark'         => $response->car->mark,
            'model'        => $response->car->model,
            'year'         => (int) $response->car->year,
            'capacity'     => (float) $response->car->capacity,
            'year_created' => date('Y-m-d'),
            'region'       => $response->car->region
        ];

        $garageModel = $repository->create($garageData);

        if (!$garageModel instanceof Garage) {
            return response('Ошибка при создании гаража', Response::HTTP_BAD_REQUEST);
        }

        return [
            'garage' => $garageModel
        ];
    }

    public function test(GarageRepository $repository)
    {
        $userId  = Auth::user()->id;
        $garages = $repository->allByUserId($userId);

        if (!empty($garages)) {
            return [
                'garages' => $garages,
                'status' => Response::HTTP_OK
            ];
        }

        return [
            'message' => "Гаражи не найдены",
            'status'  => Response::HTTP_NOT_FOUND
        ];
    }

    public function deleteGarage(GarageRepository $repository, string $vin)
    {
        if ($repository->deleteByVin($vin)) {

            return [
                'message' => "Гараж с vin $vin успешно удален",
                'status'  => Response::HTTP_OK
            ];
        }

        return [
            'message' => "Ошибка при удалении гаража",
            'status'  => Response::HTTP_NOT_FOUND
        ];
    }

    public function getGarage(GarageRepository $repository, string $vin)
    {
        $garage = $repository->findByVin($vin);

        if (!empty($garage)) {
            return [
                'garage' => $garage,
                'status' => Response::HTTP_OK
            ];
        }

        return [
            'message' => "Гараж с $vin не найден",
            'status'  => Response::HTTP_NOT_FOUND
        ];
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'street' => 'required',
            'house'  => 'required',
        ]);

        $address = new Address();

        $address->street    = $request->get('street');
        $address->house     = $request->get('house');
        $address->apartment = $request->get('apartment');
        $address->entrance  = $request->get('entrance');
        $address->user_id   = Auth::user()->id;

        if ($address->save()) {
            return [
                'message' => 'Адрес успешно сохранен',
                'status'  => Response::HTTP_OK
            ];
        }

        return [
            'message' => 'Ошибка при сохранении адреса',
            'status'  => Response::HTTP_BAD_REQUEST
        ];
    }

    public function getAddress()
    {
        $userAddresses = [];
        $addresses     = Auth::user()->address;

        if ($addresses->isEmpty()) {
            return [
                'message' => "Адреса не найдены",
                'status'  => Response::HTTP_NOT_FOUND
            ];
        }

        foreach ($addresses as $address) {
            $userAddresses[] = $address;
        }

        return [
            'addresses' => $userAddresses,
            'status'    => Response::HTTP_OK
        ];
    }

    public function deleteAddress($id)
    {
        $address = Address::query()->where('id', $id)->get();


        if ($address->isEmpty()) {
            return [
                'message' => "Адрес не найден",
                'status'  => Response::HTTP_NOT_FOUND
            ];
        }

        $delete = Address::query()->where(['id' => $id])->delete();

        if ($delete) {
            return [
                'message' => "Адрес удален",
                'status'  => Response::HTTP_OK
            ];
        }

        return [
            'message' => "Ошибка при удалении адреса",
            'status'  => Response::HTTP_BAD_REQUEST
        ];
    }

    public function profile()
    {
        $profile = Auth::user();

        if (!$profile) {
            return [
                'message' => "Профиль не найден",
                'status'  => Response::HTTP_NOT_FOUND
            ];
        }

        return [
            'profile' => $profile,
            'status'  => Response::HTTP_OK
        ];
    }

    public function changeProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name'  => 'required',
        ]);

        $profile            = Auth::user();
        $profile->name      = $request->get('name');
        $profile->last_name = $request->get('last_name');

        if ($profile->update()) {
            return [
                'message' => 'Профиль обновлен',
                'status'  => Response::HTTP_OK
            ];
        }

        return [
            'message' => 'Ошибка при обновлении профиля',
            'status'  => Response::HTTP_BAD_REQUEST
        ];
    }

    public function changePhone(Request $request)
    {
        $request->validate([
            'old_phone' => 'required',
            'new_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);

        $profile = Auth::user();

        if ($profile->phone !== $request->get('old_phone')) {
            return [
                'message' => 'Старый телефон введен не верно',
                'status'  => Response::HTTP_BAD_REQUEST
            ];
        }

        $profile->phone = $request->get('new_phone');

        if ($profile->update()) {
            return [
                'message' => 'Номер телефона обновлен',
                'status'  => Response::HTTP_OK
            ];
        }

        return [
            'message' => 'Ошибка при обновлении телефона',
            'status'  => Response::HTTP_BAD_REQUEST
        ];
    }

    public function getAllGarages(GarageRepository $repository)
    {
        $userId  = Auth::user()->id;
        $garages = $repository->allByUserId($userId);

        if (!empty($garages)) {
            return [
                'garages' => $garages,
                'status' => Response::HTTP_OK
            ];
        }

        return [
            'message' => "Гаражи не найдены",
            'status'  => Response::HTTP_NOT_FOUND
        ];
    }
}
