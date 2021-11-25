<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 25.11.2021
 * Time: 22:03
 */

namespace App\Repositories;

use App\Models\User;


class UsersRepository
{
    /**
     * @param string $phone
     * @return \App\Models\User
     */
    public function findByPhone(string $phone): User
    {
        $user = User::query()->where('phone', $phone)->first();

        if (null == $user) {
            $attributes = [
                'phone' => $phone,
            ];

            $user = $this->create($attributes);
        }

        return $user;
    }

    /**
     * @param string $phone
     * @param int $code
     * @return \App\Models\User|null
     */
    public function findByPhoneAndCode(string $phone, int $code): ?User
    {
        return User::query()->where('phone', $phone)->where('code', $code)->firstOrFail();
    }

    /**
     * @param array $attributes
     * @return \App\Models\User|null
     */
    public function create(array $attributes): ?User
    {
        return User::query()->create($attributes);
    }

    /**
     * @param \App\Models\User $user
     * @param array $attributes
     * @return bool
     */
    public function update(User $user, array $attributes): bool
    {
        return $user->update($attributes);
    }
}