<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ServiceController;
use App\Http\Requests\Product\CountProductRequest;
use App\Services\Api\Product\CountProductService;

class ApiCountProductController extends ServiceController
{
    protected const SERVICE_CLASS = CountProductService::class;
    /**
     * Handle the incoming request.
     */
    public function __invoke(CountProductRequest $request)
    {
        return parent::handle($request);
    }
}
