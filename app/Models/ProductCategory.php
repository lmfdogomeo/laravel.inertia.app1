<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    use HasUuid;

    protected $table = 'product_categories';

    protected $fillable = [
        "uuid",
        "category",
        "description"
    ];

    protected $hidden = [
        "id"
    ];

    public function products() {
        return $this->hasMany(Product::class, "product_id", "id");
    }
}
