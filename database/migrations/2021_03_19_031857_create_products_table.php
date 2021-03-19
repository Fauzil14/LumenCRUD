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
            $table->string('product_code', 13);
            $table->string('brand', 20);
            $table->string('product_name', 50);
            $table->foreignId('category_id')->constrined('categories');
            $table->integer('stock');
            $table->string('pic_one');
            $table->string('pic_two')->nullable();
            $table->string('pic_three')->nullable();
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
