<?php

namespace App\Models;


class Product extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $fillable = [
        'company_id',
        'name',
        'description',
        'article',
        'clean_article',
        'brand',
        'price',
        'quantity',
        'min_quantity',
        'category_id',
        'is_original',
        'shipping_types',
        'image',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
