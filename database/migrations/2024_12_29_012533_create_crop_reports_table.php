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
        Schema::create('crop_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Foreign key for user
            $table->unsignedBigInteger('modified_by')->nullable(); // Foreign key for user who modified the record
            $table->string('cropName');
            $table->string('variety');
            $table->string('type');
            $table->decimal('areaPlanted', 8, 2); // Example: 12345.67 hectares
            $table->decimal('productionVolume', 8, 2); // Example: 12345.67 metric tons
            $table->decimal('yield', 8, 2); // Example: 12345.67 metric tons per hectare
            $table->decimal('price', 10, 2); // Example: 1234567.89 currency units
            $table->string('monthObserved', 7); // Store as string with format YYYY-MM
            $table->timestamps();

            // Set up foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_reports');
    }
};
