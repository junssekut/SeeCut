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
        Schema::create('vendor_open_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');

            $table->string('day');
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();

            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_open_hours');
    }
};
