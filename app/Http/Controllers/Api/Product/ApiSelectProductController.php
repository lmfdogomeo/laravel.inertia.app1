<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ServiceController;
use App\Http\Requests\Product\SelectProductRequest;
use App\Services\Api\Product\SelectProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiSelectProductController extends ServiceController
{
    protected const SERVICE_CLASS = SelectProductService::class;
    /**
     * Handle the incoming request.
     */
    public function __invoke(SelectProductRequest $request): JsonResource | JsonResponse
    {
        return parent::handle($request);
    }
}
