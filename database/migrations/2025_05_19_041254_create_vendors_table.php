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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->text('address')->nullable()->default('');
            $table->string('phone')->nullable();
            $table->float('rating')->nullable()->default(0.0);
            $table->integer("reviews_count")->nullable()->default(0);
            $table->unsignedBigInteger('thumbnail_id')->nullable(); # foreign to VendorPhoto, just get the fucking thumbnail from VendorPhoto model
            $table->float('latitude');
            $table->float('longitude');
            $table->string('place_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('thumbnail_id')->references('id')->on('vendor_photos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
