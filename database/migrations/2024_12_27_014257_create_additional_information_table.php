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
        Schema::create('additional_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crop_id'); // Foreign key for crop
            $table->json('fileHolder')->nullable(); // Store file data as JSON
            $table->timestamps();

            // Set up foreign key constraint
            $table->foreign('crop_id')->references('id')->on('crops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_information');
    }
};
