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
        Schema::create('vendor_hairstylists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            
            $table->string('name');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->text('description');

            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('vendor_photos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_hairstylists');
    }
};
