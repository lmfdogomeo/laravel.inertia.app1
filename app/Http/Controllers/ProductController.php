<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Repositories\Contracts\MerchantRepositoryInterface;
use App\Repositories\Contracts\ProductCategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(protected ProductRepositoryInterface $repository, protected MerchantRepositoryInterface $merchantRepository, protected ProductCategoryRepositoryInterface $categoryRepository)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [];
        $merchantUuid = $request->query("merchant");
        $categoryUuid = $request->query("category");
        $stockStatus = $request->query("stock-status");
        if (!empty($merchantUuid)) {
            $merchant = $this->merchantRepository->findByUuid($merchantUuid);
            $filters[] = ['merchant_id', "=", $merchant->id];
        }
        if (!empty($categoryUuid)) {
            $category = $this->categoryRepository->findByUuid($categoryUuid);
            $filters[] = ['category_id', "=", $category->id];
        }
        if (!empty($stockStatus)) {
            $filters[] = ['stock_status', "LIKE", "%{$stockStatus}%"];
        }
        
        $data = $this->repository->paginate($request->size ?? 5, $filters);

        return Inertia::render("Admin/Product/ProductList", [
            "merchant_uuid" => $merchantUuid,
            "paginate" => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $merchantUuid = $request->query("merchant");
        return Inertia::render("Admin/Product/ProductForm", [
            "merchant_uuid" => $merchantUuid,
            "state" => "create"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $category = $this->categoryRepository->findByUuid($request->category_id);
        $merchant = $this->merchantRepository->findByUuid($request->merchant_id);

        $request->merge([
            "category_id" => $category->id,
            "merchant_id" => $merchant->id
        ]);

        $product = $this->repository->create($request->parameters());

        return redirect()->back()
            ->with('code', '200')
            ->with('status', 'success')
            ->with('message', 'Product created successfully!')
            ->with('data', $product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $uuid)
    {
        $filters = [];

        $merchantUuid = $request->query('merchant');
        if (!empty($merchantUuid)) {
            $merchant = $this->merchantRepository->findByUuid($merchantUuid);
            $filters = [
                ['merchant_id', "=", $merchant->id]
            ];
        }

        $product = $this->repository->findByUuid($uuid, ['category', 'merchant'], [], $filters);
        return Inertia::render("Admin/Product/ProductForm", [
            'data' => $product,
            "state" => "update",
            "merchant_uuid" => $merchantUuid,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $uuid)
    {
        $merchantUuid = $request->query('merchant');

        $category = $this->categoryRepository->findByUuid($request->category_id);
        $merchant = $this->merchantRepository->findByUuid($request->merchant_id);
        $request->merge([
            "category_id" => $category->id,
            "merchant_id" => $merchant->id
        ]);

        $filters = [];
        if (!empty($merchantUuid)) {
            $merchant = $this->merchantRepository->findByUuid($merchantUuid);
            $filters = [
                ["merchant_id", "=", $merchant->id]
            ];
        }

        $product = $this->repository->update($uuid, $request->parameters(), $filters);

        return redirect()->back()
            ->with('code', '200')
            ->with('status', 'success')
            ->with('message', 'Product updated successfully!')
            ->with('data', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $uuid)
    {
        $merchantUuid = $request->query('merchant');

        $filters = [];
        $routeQueryParams = [];
        if (!empty($merchantUuid)) {
            $merchant = $this->merchantRepository->findByUuid($merchantUuid);
            $filters = [
                ["merchant_id", "=", $merchant->id]
            ];

            $routeQueryParams = [
                "merchant" => $merchantUuid
            ];
        }

        $product = $this->repository->delete($uuid, $filters);

        return Redirect()->route('admin.products.index', $routeQueryParams)
            ->with('code', '200')
            ->with('status', 'success')
            ->with('message', 'Product deleted successfully!')
            ->with('data', $product);
    }

    public function filter(Request $request)
    {
        $filters = [];
        $merchantUuid = $request->query("merchant");
        $categoryUuid = $request->query("category");
        $stockStatus = $request->query("stock-status");
        if (!empty($merchantUuid)) {
            $merchant = $this->merchantRepository->findByUuid($merchantUuid);
            $filters[] = ['merchant_id', "=", $merchant->id];
        }
        if (!empty($categoryUuid)) {
            $category = $this->categoryRepository->findByUuid($categoryUuid);
            $filters[] = ['category_id', "=", $category->id];
        }
        if (!empty($stockStatus)) {
            $filters[] = ['stock_status', "LIKE", "%{$stockStatus}%"];
        }
        
        $data = $this->repository->paginate($request->size ?? 5, $filters);

        return Inertia::render("Admin/Product/ProductList", [
            "merchant_uuid" => "",
            "paginate" => $data,
        ]);
    }
}
