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
        Schema::create('vendor_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            
            $table->enum('type', ['local', 'link']);
            $table->enum('category', ['general', 'hairstylist'])->nullable()->default('general');
            $table->string('source');

            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_photos');
    }
};
