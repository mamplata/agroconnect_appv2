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
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Foreign key for user
            $table->unsignedBigInteger('modified_by')->nullable(); // Foreign key for user who modified the record
            $table->string('cropName');
            $table->string('variety')->nullable();
            $table->string('type');
            $table->text('description')->nullable(); // Added description
            $table->string('planting_period')->nullable(); // Added planting period
            $table->integer('growth_duration')->nullable(); // Growth duration in days
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
        Schema::dropIfExists('crops');
    }
};
