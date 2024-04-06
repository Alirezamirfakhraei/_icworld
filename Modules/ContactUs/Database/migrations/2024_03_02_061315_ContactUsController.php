<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\ContactUs\App\Models\ContactUs;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->string('email' , 256);
            $table->string('fullName' , 50)->nullable();
            $table->string('subject' , 256)->nullable();
            $table->longText('message')->nullable();
            $table->enum('status' , ContactUs::$status);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
