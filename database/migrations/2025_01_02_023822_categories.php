<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function(Blueprint $table){
            $table->id('category_id')->primary(); 
		$table->string('category_name', 100)->nullable(false); 
		$table->timestamps();
        });
    }

    
    public function down(): void
    {
        
    }
};
