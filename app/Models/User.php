<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements \Illuminate\Contracts\Auth\Authenticatable
{
    use \Illuminate\Auth\Authenticatable,
        \Illuminate\Foundation\Auth\Access\Authorizable,
        \Laravel\Sanctum\HasApiTokens,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'code',
        'password',
        'city_id',
    ];

    protected $appends = ['average_rating', 'feedbacks_count'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'supplier_id', 'id');
    }

    public function getAverageRatingAttribute()
    {
        return (float)$this->feedbacks()->average('star');
    }

    public function getFeedbacksCountAttribute()
    {
        return $this->feedbacks()->count();
    }
}
