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
        Schema::create('parfums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->decimal('price')->default(0);
            $table->integer('stock')->default(0);
            $table->enum('sex', ['male', 'female', 'unisex'])->default('male');
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parfums', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
        });

        Schema::dropIfExists('parfums');
    }
};
