<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 23.04.2022
 * Time: 14:44
 */

namespace App\Models;


class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'address_id',
        'status',
        'grand_total',
        'items_count',
        'time',
        'payment_method',
        'notes'
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
}