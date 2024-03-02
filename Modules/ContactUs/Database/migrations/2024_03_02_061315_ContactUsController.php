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
        Schema::create('contactUs', function (Blueprint $table) {
            $table->id();
            $table->string('email' , 256);
            $table->string('fullName' , 50);
            $table->string('subject' , 256);
            $table->longText('message');
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
