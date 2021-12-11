<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 28.11.2021
 * Time: 01:50
 */

namespace App\Services\AutoPartsApiService;

use Illuminate\Support\Facades\Http;


class Client
{
    protected $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function search($vin, $categories) {
        $request = Http::withBasicAuth(env('AUTO_PARTS_API_USERNAME'), env('AUTO_PARTS_API_PASSWORD'));

        return $request->post($this->baseUrl . '/api/v1/search?vin=' . $vin . '&category_id=' . $categories);
    }

    public function getCategories()
    {
        $request = Http::withBasicAuth(env('AUTO_PARTS_API_USERNAME'), env('AUTO_PARTS_API_PASSWORD'));

        return $request->get($this->baseUrl . '/api/v1/get_categories');
    }

}