<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 28.11.2021
 * Time: 01:49
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Services\AutoPartsApiService\Client;

class AutoPartsApiProvider extends ServiceProvider
{
    public function register()
    {
        $baseUrl = env('AUTO_PARTS_API_URI');

        $this->app->singleton(Client::class, function($api) use ($baseUrl) {
            return new Client(
                $baseUrl
            );
        });
    }

    public function boot()
    {
        //
    }
}