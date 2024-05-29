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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid")->unique();
            $table->string("image_path");
            $table->string("size")->nullable();
            $table->string("description")->nullable();
            $table->boolean("main_display")->default(false);
            $table->bigInteger("product_id")->index()->unsigned();
            $table->foreign("product_id")->references("id")->on("products")->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
