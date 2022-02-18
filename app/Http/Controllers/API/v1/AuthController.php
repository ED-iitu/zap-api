<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 25.11.2021
 * Time: 22:00
 */

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Repositories\UsersRepository;

class AuthController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Repositories\UsersRepository $repository
     *
     */
    public function login(Request $request, UsersRepository $repository)
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

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Repositories\UsersRepository $repository
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request, UsersRepository $repository): JsonResponse
    {
        $request->validate([
            'phone' => 'required',
            'code' => 'required|digits:4',
        ]);

        $user = $repository->findByPhoneAndCode($request->get('phone'), $request->get('code'));
        $user->update(['code' => null]);

        return response()->json(['token' => $user->createToken('api')->plainTextToken]);
    }

    /**
     * @param \App\Models\User $user
     * @return void
     */
    private function updateCodeAndSendSMS(User $user): void
    {
        //$code = rand(1000, 9999);
        //Для тестирования
        $code = 1111;

        $user->update(['code' => $code]);

        //TODO Тут реальзивать отправку СМС через СМС центр
    }
}