<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        "uuid",
        "sku",
        "brand_name",
        "product_name",
        "product_description",
        "price",
        "sale_price",
        "is_sale",
        "quantity",
        "sale",
        "stock_status",
        "stock_quantity",
        "sold_quantity",
        "unit",
        "start_date",
        "size",
        "weight",
        "rate",
        "category_id",
        "merchant_id",
    ];

    protected $hidden = [
        "id"
    ];

    public function merchant() {
        return $this->belongsTo(Merchant::class, "merchant_id", "id");
    }

    public function category() {
        return $this->belongsTo(ProductCategory::class, "category_id", "id");
    }

    public function images() {
        return $this->hasMany(ProductImage::class, "product_id", "id");
    }
}
