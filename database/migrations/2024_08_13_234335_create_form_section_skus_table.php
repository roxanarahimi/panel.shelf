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
        Schema::create('form_section_skus', function (Blueprint $table) {
            $table->id();
            $table->integer('form_section_id');
            $table->integer('sku_id');

            $table->integer('face');
            $table->integer('presence');
            $table->string('expire_date');

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
        Schema::dropIfExists('form_section_skus');
    }
};
