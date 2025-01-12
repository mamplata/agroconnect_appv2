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
        Schema::create('damage_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Foreign key for user
            $table->unsignedBigInteger('modified_by')->nullable(); // Foreign key for user who modified the record
            $table->string('cropName');
            $table->string('variety');
            $table->enum('type', ['Rice', 'Vegetables', 'Fruits']);  // Crop type
            $table->enum('damage_type', ['Natural Disaster', 'Pest', 'Disease']);
            $table->string('natural_disaster_type')->nullable();  // Only if damage type is 'Natural Disaster'
            $table->string('damage_name')->nullable();  // damage name
            $table->float('area_planted');  // Full area in hectares
            $table->float('area_affected');  // Affected area in hectares
            $table->string('monthObserved', 7); // Month observed (Date format)
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
        Schema::dropIfExists('damage_reports');
    }
};
