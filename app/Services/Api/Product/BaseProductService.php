<?php

namespace App\Services\Api\Product;

use App\Repositories\Api\Product\ApiProductRepositoryInterface;
use App\Services\ServiceInterface;

abstract class BaseProductService implements ServiceInterface
{
    public function __construct(protected readonly ApiProductRepositoryInterface $repository)
    {
        
    }
}