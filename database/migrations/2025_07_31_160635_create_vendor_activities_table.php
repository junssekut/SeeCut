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
        Schema::create('vendor_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->string('activity_type'); // 'update', 'create', 'confirm', 'upload', etc.
            $table->string('activity_description'); // Human readable description
            $table->string('entity_type')->nullable(); // 'profile', 'service', 'photo', 'reservation', etc.
            $table->unsignedBigInteger('entity_id')->nullable(); // ID of the related entity
            $table->json('metadata')->nullable(); // Additional data about the activity
            $table->timestamps();
            
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['vendor_id', 'created_at']);
            $table->index('activity_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_activities');
    }
};
