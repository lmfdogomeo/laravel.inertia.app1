<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ServiceController;
use App\Http\Requests\Product\DataPerMonthProductRequest;
use App\Services\Api\Product\DataPerMonthProductService;

class ApiPerMonthProductController extends ServiceController
{
    protected const SERVICE_CLASS = DataPerMonthProductService::class;
    /**
     * Handle the incoming request.
     */
    public function __invoke(DataPerMonthProductRequest $request)
    {
        return parent::handle($request);
    }
}
