<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;
    use HasUuid;

    protected $guarded = ['id'];

    protected $fillable = [
        "uuid",
        "company_name",
        "company_tax_id",
        "contact_number",
        "address",
        "city",
        "country",
        "postal_code",
    ];

    protected $hidden = [
        'id',
    ];

    public function merchantUser() {
        return $this->hasOne(MerchantUser::class, "merchant_id", "id");
    }

    public function products() {
        return $this->hasMany(Product::class, "merchant_id", "id");
    }
}
