<?php

namespace App\Services\Api\Product;

use App\Enums\UserRoles;
use App\Http\Requests\Contracts\RequestContract;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class SelectProductService extends BaseProductService
{
    public function __invoke(RequestContract $request): JsonResource|JsonResponse
    {
        $user = auth()->user();
        $filter = [];
        if ($user->role->is(UserRoles::MERCHANT)) {
            $merchantId = $user->merchantUser->merchant->id ?? null;
            $filter = [
                ["merchant_id", "=", $merchantId]
            ];
        }

        $product = $this->repository->findByUuid($request->uuid(), [], [], $filter);
    
        if ($product === null) {
            throw new \InvalidArgumentException('Product not found.', Response::HTTP_NOT_FOUND);
        }

        return new ProductResource($product->refresh());
    }
}