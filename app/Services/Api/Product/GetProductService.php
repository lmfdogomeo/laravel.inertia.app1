<?php

namespace App\Services\Api\Product;

use App\Enums\UserRoles;
use App\Http\Requests\Contracts\RequestContract;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class GetProductService extends BaseProductService
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
        $product = $this->repository->paginate($request->size ?? 5, $filter);

        // $search = $request->search ?? "";
        // $product = $this->repository->where(function ($query) use($search) {
        //     $query->where('product_name', "LIKE", "%$search%")
        //         ->orWhere("stock_quantity", "=", $search)
        //         ->orWhere("stock_status", "LIKE", "%$search%")
        //         ->orWhere("price", "=", $search)
        //         ->orWhere("rate", "=", $search);
        // })->paginate($request->size ?? 5);

        // // return response()->json([
        // //     'user' => authenticatedUser(),
        // //     'data' => $test,
        // // ]); 
        
        return ProductResource::collection($product);
    }
}