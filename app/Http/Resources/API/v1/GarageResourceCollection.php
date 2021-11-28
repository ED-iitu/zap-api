<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 28.11.2021
 * Time: 17:18
 */

namespace App\Http\Resources\API\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GarageResourceCollection extends ResourceCollection
{
    /**
     * @var string
     */
    public $collects = GarageResource::class;

    /**
     * @var string
     */
    public static $wrap = 'garages';
}