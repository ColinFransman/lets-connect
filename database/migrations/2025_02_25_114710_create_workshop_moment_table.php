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
        Schema::create('workshop_moments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('moment_id');
            $table->unsignedBigInteger('workshop_id');
            $table->foreign('moment_id')->references('id')->on('moments');
            $table->foreign('workshop_id')->references('id')->on('workshops');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshop_moment');
    }
};
