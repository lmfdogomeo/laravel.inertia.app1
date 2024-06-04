<?php

namespace App\Services\Api\Product;

use App\Enums\UserRoles;
use App\Http\Requests\Contracts\RequestContract;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class DataPerMonthProductService extends BaseProductService
{
    public function __invoke(RequestContract $request): JsonResource|JsonResponse
    {
        $user = auth()->user();
        if (!$user->role->is(UserRoles::MERCHANT)) {
            throw new \InvalidArgumentException('Unauthorized.', Response::HTTP_UNAUTHORIZED);
        }

        $merchantId = $user->merchantUser->merchant->id ?? null;
        $year = Date("Y");

        $data = $this->repository->dataPerMonthByYear($year, $merchantId);

        return response()->json([
            'data' => $data
        ]);
    }
}