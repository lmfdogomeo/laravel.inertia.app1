<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    use HasUuid;

    protected $table = 'product_images';

    protected $fillable = [
        "uuid",
        "image_path",
        "size",
        "description",
        "main_display",
        "product_id",
    ];

    protected $hidden = [
        "id"
    ];

    public function product() {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
