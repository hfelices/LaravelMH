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
        Schema::create('visibilities', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('visibility_id')->default(1);
            $table->foreign('visibility_id')->references('id')->on('visibilities');
        });

        Schema::table('places', function (Blueprint $table) {
            $table->unsignedBigInteger('visibility_id')->default(1);
            $table->foreign('visibility_id')->references('id')->on('visibilities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visibilities');
    }
};
