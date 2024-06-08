<?php

namespace App\Services\Product\Facade;

use Illuminate\Support\Facades\Facade;

class ProductAction extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'product.action';
    }
}
