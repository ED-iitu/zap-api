<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 10.05.2022
 * Time: 20:28
 */

namespace App\Models;


class Feedback extends Model
{
    /**
     * @var string
     */
    protected $table = 'feedbacks';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'supplier_id',
        'product_id',
        'comment',
        'star',
    ];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}