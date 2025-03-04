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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->foreignId('type_id')->constrained();
            $table->foreignId('brand_id')->constrained();

            $table->string('thumbnail_photos')->nullable();
            $table->string('photos')->nullable();

            $table->text('features')->nullable();
            $table->integer('price')->nullable();
            $table->double('star')->nullable();
            $table->integer('review')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
