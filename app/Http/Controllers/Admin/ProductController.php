<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 23.04.2022
 * Time: 15:07
 */

namespace App\Http\Controllers\Admin;

use App\Jobs\ImportProducts;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('company')->get();

        return view('admin.products.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $suppliers = User::where('type', 2)->get();

        return view('admin.products.form', [
            'title' => "Добавление Запчасти",
            'suppliers' => $suppliers,
            'action' => route("products.store"),
        ]);
    }

    public function store(Request $request)
    {
        if ($image = $request->file('image')) {
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

            $destinationPath = 'public/storage';

            $image->move($destinationPath, $input['imagename']);

            $imageLink = $destinationPath.'/'.$input['imagename'];
        }

        $data = [
            "name" => $request->name,
            "description" => $request->desccription,
            "company_id" => $request->company_id,
            "article" => $request->article,
            "clean_article" => $request->article,
            "price" => $request->price,
            "brand" => $request->brand,
            "image" => $imageLink ?? null,
        ];

        Product::create($data);

        return redirect()->route("products.index");
    }

    public function edit(Product $product)
    {
        $suppliers = User::where('type', 2)->get();

        return view('admin.products.form', [
            'title' => "Редактирование предмета - $product->id",
            'product' => $product,
            'action' => route("products.update", $product),
            'suppliers' => $suppliers
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return redirect()->route("products.edit", $product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route("products.index");
    }

    public function importPage()
    {
        return view('admin.products.import');
    }

    public function import(Request $request)
    {
        $importFile    = $request->file('importFile');
        $hash          = Str::random(20);
        $fileExtension = $importFile->getClientOriginalExtension();

        $filePath = $importFile->storeAs(
            'uploads', $hash . '.' . $fileExtension
        );

        Log::info($filePath);
        Log::info("Начинаем загрузку");

        ImportProducts::dispatch($filePath);

        return back()->withStatus('Import done!');
    }
}
