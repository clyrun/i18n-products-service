<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_translations', function (Blueprint $table) {
            $table->integer('translation_id')->autoIncrement();
            $table->string('locale', 255)->index();
            $table->integer('product_id')->index();
            $table->string('product_name', 255)->nullable();
            $table->text('product_desc')->nullable();
            $table->string('product_category', 20)->nullable();


            //Apply constraint for the product_id field
            $table->foreign('product_id')->references('product_id')->on('products');
            //Don't allow duplicate locale per product id
            $table->unique(['locale', 'product_id']);
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
        Schema::dropIfExists('product_translations');
    }
}
