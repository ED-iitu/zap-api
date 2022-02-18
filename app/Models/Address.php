<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 18.02.2022
 * Time: 23:19
 */

namespace App\Models;


class Address extends Model
{
    /**
     * @var string
     */
    protected $table = 'address';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'street',
        'house',
        'flat',
        'entrance',
        'user_id'
    ];

    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}