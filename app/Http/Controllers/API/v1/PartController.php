<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 21.03.2022
 * Time: 15:51
 */

namespace App\Http\Controllers\API\v1;

use App\Services\Supplier\Client as SupplierClient;


class PartController extends Controller
{
    public function getOne($id, SupplierClient $client)
    {
        $supplierData = $client->getOne($id)->json();

        if (isset($supplierData['success']) && $supplierData['success'] == false) {
            return $supplierData;
        }

        return [
            'success' => true,
            'data' => [
                'part' => $supplierData
            ]
        ];
    }
}