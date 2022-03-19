<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 18.03.2022
 * Time: 23:45
 */

namespace App\Services\Supplier;

use Illuminate\Support\Facades\Http;

class Client
{
    protected $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function search(array $oemsArray, string $brand)
    {
        $request = Http::withBasicAuth(env('SUPPLIER_API_USERNAME'), env('SUPPLIER_API_PASSWORD'));

        $oems = [];

        foreach ($oemsArray as $oem) {
            $oems[] = "oem[]=$oem";
        }

        $implode = implode('&', $oems);

        return $request->get($this->baseUrl . "/api/v1/search?$implode&brand=$brand");
    }
}