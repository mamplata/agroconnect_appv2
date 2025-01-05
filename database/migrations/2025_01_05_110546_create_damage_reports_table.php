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
            $table->string('crop_name');
            $table->string('variety');
            $table->enum('type', ['Rice', 'Vegetables', 'Fruits']);  // Crop type
            $table->enum('damage_type', ['Natural Disaster', 'Pest', 'Disease']);
            $table->string('natural_disaster_type')->nullable();  // Only if damage type is 'Natural Disaster'
            $table->string('disaster_name')->nullable();  // Only if damage type is 'Natural Disaster'
            $table->string('pest_or_disease')->nullable();  // Only if damage type is 'Pest' or 'Disease'
            $table->float('area_planted');  // Full area in hectares
            $table->float('area_affected');  // Affected area in hectares
            $table->date('month_observed');  // Month observed (Date format)
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedBigInteger('modifier_id')->nullable();
            $table->timestamps();

            // Foreign key constraints (assuming the users table exists)
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('modifier_id')->references('id')->on('users')->onDelete('set null');
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
