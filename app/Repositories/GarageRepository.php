<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 28.11.2021
 * Time: 14:53
 */

namespace App\Repositories;


use App\Models\Garage;
use Illuminate\Database\Eloquent\Collection;

class GarageRepository
{
    public function create(array $data): ?Garage
    {
        return Garage::query()->create($data);
    }

    public function findByVin(string $vin): ?Garage
    {
        return Garage::query()->where('vin', $vin)->first();
    }

    public function all(): ?Collection
    {
        return Garage::query()->get();
    }

    public function allByUserId(int $userId)
    {
        return Garage::query()->where('user_id', $userId)->get();
    }

    public function deleteByVin(string $vin)
    {
        return Garage::query()->where('vin', $vin)->delete();
    }
}