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
        Schema::create('collaborators', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('represents first name');
            $table->string('lastName')->nullable()->comment('represents last name');
            $table->string('address')->nullable()->comment('represents the address');
            $table->string('email')->nullable()->unique()->comment('represents the email address');
            $table->string('phone')->nullable()->comment('represents the phone number');
            $table->string('location')->nullable()->comment('represents the locality');
            $table->string('country')->nullable()->comment('represents the country');
            $table->string('ruc')->nullable()->comment('represents the ruc');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborators');
    }
};
