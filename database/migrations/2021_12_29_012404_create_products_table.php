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
            $table->id();
            $table->integer('product_category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('subTitle')->nullable();
            $table->longText('text')->nullable();
            $table->longText('image')->nullable();
            $table->boolean('active')->default(0);
            $table->integer('price')->default(0);
            $table->integer('off')->default(0);

            $table->timestamps();
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
