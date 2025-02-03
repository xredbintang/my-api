<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
	Schema::create('products', function (Blueprint $table) {
		$table->id('product_id')->primary(); 
		$table->string('product_name', 100)->nullable(false);
        $table->foreignId('product_category_id')->constrained('categories','category_id')->cascadeOnUpdate()->cascadeOnDelete();  
		$table->integer('product_stock')->nullable(false); 
		$table->integer('product_price')->nullable(false); 
		$table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
