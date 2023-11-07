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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('description',255);
            $table->bigInteger('file_id');
            $table->float('latitude');
            $table->float('longitude');
            $table->bigInteger('author_id');
            $table->timestamps();

            $table->foreign('file_id')->references('id')->on('files');
            $table->foreign('author_id')->references('id')->on('users');

            // $table->bigInteger('category_id')->default(1);
            // $table->bigInteger('visibility_id')->default(1);
            //$table->foreign('category_id')->references('id')->on('categories');
            //$table->foreign('visibility_id')->references('id')->on('visibilities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
