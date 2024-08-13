<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('form_id');

            $table->integer('sku_category_id');
            $table->integer('brand_id');

            $table->string('space');
            $table->string('layout');
            $table->string('image');

            $table->integer('face');
            $table->integer('presence');
            $table->integer('expire_date');

            $table->integer('label_price');
            $table->integer('sale_price');
            $table->integer('distribute_price');

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
        Schema::dropIfExists('form_sections');
    }
};
