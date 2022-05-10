<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 09.05.2022
 * Time: 18:34
 */

namespace App\Imports;

use App\Models\User;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    private $user;

    public function __construct()
    {
        $this->user = request()->user();
    }

    public function model(array $row)
    {
        return new Product([
            'company_id' => $this->user->id,
            'name' => $row['naimenovanie'],
            'description' => $row['naimenovanie'],
            'article' => $row['kod'],
            'clean_article' => $row['kod'],
            'brand' => $row['proizvoditel'],
            'price' => $row['cenar_roznica'],
            'quantity' => 10000,
            'min_quantity' => 1,
            'category_id' => null,
            'is_original' => 0,
            'shipping_types' => null,
            'image' => null,
        ]);
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    public function batchSize(): int
    {
        return 5000;
    }
}