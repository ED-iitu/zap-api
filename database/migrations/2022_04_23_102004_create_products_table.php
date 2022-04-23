<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->string('name', 255)->nullable();
            $table->longText('description')->nullable();
            $table->string('article', 255);
            $table->string('clean_article', 255);
            $table->string('brand', 255);
            $table->integer('price')->default(0);
            $table->integer('quantity')->default(1);
            $table->integer('min_quantity')->default(1);
            $table->string('shipping_types')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_original')->default(1);
            $table->integer('category_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
