<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 28.11.2021
 * Time: 17:01
 */

namespace App\Http\Resources\API\v1;

use Illuminate\Http\Resources\Json\JsonResource;


class GarageResource extends JsonResource
{
    public static $wrap = 'garages';

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'vin'          => $this->vin,
            'mark'         => $this->mark,
            'model'        => $this->model,
            'year'         => $this->year,
            'car_image'    => $this->car_image,
            'capacity'     => $this->capacity,
            'year_created' => $this->year_created,
            'region'       => $this->region,
        ];
    }
}