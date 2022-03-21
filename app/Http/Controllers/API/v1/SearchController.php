<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 23.01.2022
 * Time: 15:42
 */

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\AutoPartsApiService\Client as AutoPartClient;
use App\Services\Supplier\Client as SupplierClient;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    public function search(Request $request, AutoPartClient $autoParts, SupplierClient $supplier)
    {
        $validator = Validator::make($request->all(), [
            'vin'         => 'required|regex:/^[A-HJ-NPR-Za-hj-npr-z\d]{8}[\dX][A-HJ-NPR-Za-hj-npr-z\d]{2}\d{6}$/|min:17',
            'category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'message' => $validator->errors(),
                'status'  => Response::HTTP_BAD_REQUEST
            ];
        }

        $vin            = $request->get('vin');
        $categories     = implode(',', $request->get('category_id'));
        $autoPartsData  = $autoParts->search($vin, $categories);
        $autoPartsData  = json_decode($autoPartsData);
        $brand          = $autoPartsData->car->mark;
        $data           = [];

        foreach ($autoPartsData->parts as $key => $part) {
            $category = null;
            $oems = [];

            foreach ($part as $item) {
                $category = $item->category;
                $oems[]   = $item->oem;
            }

            if (!empty($oems)) {
                $dataFromSupplier = $supplier->search($oems, $brand)->json();
                $data[]           = [
                    'items_more'     => count($dataFromSupplier),
                    'category_id'    => $category->id,
                    'category_title' => $category->name,
                    'parts'          => [
                        $dataFromSupplier[0] ?? []
                    ],
                ];
            }
        }

        $result = [
            'success' => true,
            'data'    => [
                'categories' => $data,
                'car'        => $autoPartsData->car,
            ],
        ];

        return $result;
    }
}