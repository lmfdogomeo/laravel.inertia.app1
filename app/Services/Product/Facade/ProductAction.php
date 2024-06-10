<?php

namespace App\Services\Product\Facade;

use App\Services\Product\Actions\StoreAction;
use Illuminate\Support\Facades\Facade;

/**
 * @method static  StoreAction action(array $parameters)
 *
 * @see \App\Services\Product\Action
 */
class ProductAction extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'product.action';
    }
}
