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
        Schema::create('customer_grade_scores', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('meterage');
            $table->integer('product_variety');
            $table->integer('product_layout');
            $table->integer('equipment');
            $table->longText('image')->nullable();
            $table->integer('sector_id');
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
        Schema::dropIfExists('customer_grade_scores');
    }
};
