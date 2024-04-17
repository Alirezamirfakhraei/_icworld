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
            $table->id();
            $table->string('dk_part_number' , 150);
            $table->string('mfr_part_number' , 150);
            $table->string('ice_part_number' , 150);
            $table->string('categoryID' , 10);
            $table->string('categorySubID' , 10);
            $table->string('categoryBranchID' , 10)->nullable();
            $table->string('currency' , 5)->default('USD');
            $table->string('description' , 256)->nullable();
            $table->string('price' , 50);
            $table->enum('status' , \Modules\Products\App\Models\Product::$statuses);
            $table->string('image' , 256)->nullable();
            $table->string('dataSheet' , 256)->nullable();
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
