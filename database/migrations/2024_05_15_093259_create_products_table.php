<?php

use App\Enums\ProductUnits;
use App\Enums\StockStatus;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid")->unique();
            $table->string("sku", 100)->unique();
            $table->string("brand_name");
            $table->string("product_name");
            $table->string("product_description");
            $table->double("price", [10, 2]);
            $table->double("sale_price", [10, 2]);
            $table->boolean("is_sale")->default(false);
            $table->integer("quantity");
            $table->integer("sale")->default(0);
            $table->enum("stock_status", StockStatus::values())->default(StockStatus::IN_STOCK->value);
            $table->integer("stock_quantity")->default(0);
            $table->integer("sold_quantity")->default(0);
            $table->enum("unit", ProductUnits::values())->default(ProductUnits::PIECES->value);
            $table->date("start_date");
            $table->string("size")->nullable();
            $table->string("weight")->nullable();
            $table->tinyInteger("rate")->default(0);
            $table->bigInteger("category_id")->index()->unsigned();
            $table->bigInteger("merchant_id")->index()->unsigned();
            $table->foreign("category_id")->references("id")->on("product_categories")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("merchant_id")->references("id")->on("merchants")->cascadeOnDelete()->cascadeOnUpdate();
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
