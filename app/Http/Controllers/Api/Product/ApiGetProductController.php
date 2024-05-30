<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ServiceController;
use App\Http\Requests\Product\GetProductRequest;
use App\Services\Api\Product\GetProductService;

class ApiGetProductController extends ServiceController
{
    protected const SERVICE_CLASS = GetProductService::class;
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetProductRequest $request)
    {
        return parent::handle($request);
    }
}
