<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 28.11.2021
 * Time: 14:53
 */

namespace App\Models;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $vin
 * @property string $mark
 * @property string $model
 * @property integer $year
 * @property float $capacity
 * @property string $year_created
 * @property string $region
 */
class Garage extends Model
{
    /**
     * @var string
     */
    protected $table = 'garages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'vin',
        'mark',
        'model',
        'year',
        'capacity',
        'year_created',
        'region'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}