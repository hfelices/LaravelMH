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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('body', 255);
            $table->bigInteger('file_id');
            $table->float('latitude');
            $table->float('longitude');
            
            $table->bigInteger('author_id')->unsigned(); 
            $table->timestamps();

            
            $table->foreign('author_id')->references('id')->on('users');


            // Visibility
            // $table->bigInteger('visibility_id');
            // $table->foreign('visibility_id')->references('id')->on('visibilities');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
