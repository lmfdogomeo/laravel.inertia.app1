<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Http\Requests\Product\CreateFormProductRequest;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\DeleteProductRequest;
use App\Http\Requests\Product\GetProductRequest;
use App\Http\Requests\Product\SelectProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Repositories\Contracts\FileRepositoryInterface;
use App\Repositories\Contracts\MerchantRepositoryInterface;
use App\Repositories\Contracts\ProductCategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Product\Facade\ProductAction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        protected ProductRepositoryInterface $repository, 
        protected MerchantRepositoryInterface $merchantRepository, 
        protected ProductCategoryRepositoryInterface $categoryRepository,
        protected FileRepositoryInterface $fileRepository,
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(GetProductRequest $request)
    {
        $filters = [];
        $merchantUuid = $request->query("merchant");
        $categoryUuid = $request->query("category");
        $stockStatus = $request->query("stock-status");
        
        if (!empty($categoryUuid)) {
            $category = $this->categoryRepository->findByUuid($categoryUuid);
            $filters[] = ['category_id', "=", $category->id];
        }
        if (!empty($stockStatus)) {
            $filters[] = ['stock_status', "LIKE", "%{$stockStatus}%"];
        }

        if ($request->user()?->role->is(UserRoles::MERCHANT)) {
            $uuid = $request->user()->merchantUser->merchant->uuid;
            $merchant = $this->merchantRepository->findByUuid($uuid);
            $filters[] = ['merchant_id', "=", $merchant->id];
        }
        else {
            if (!empty($merchantUuid)) {
                $merchant = $this->merchantRepository->findByUuid($merchantUuid);
                $filters[] = ['merchant_id', "=", $merchant->id];
            }
        }
        
        $data = $this->repository->paginate($request->size ?? 5, $filters, ['images' => function($query) {
            $query->where('main_display', 1);
        }], []);

        // Modify each record to include the full URL for the image path
        $data->getCollection()->transform(function ($item) {
            if (isset($item->images[0])) {
                $item->image_path = $item->images[0]->image_path;
            } else {
                $name = trim(collect(explode(' ', $item->product_name))->map(function ($segment) {
                    return mb_substr($segment, 0, 1);
                })->join(' '));
        
                $item->image_path = 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
            }

            unset($item->images);

            return $item;
        });

        return Inertia::render("Admin/Product/ProductList", [
            "merchant_uuid" => $merchantUuid,
            "paginate" => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateFormProductRequest $request)
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
        // $category = $this->categoryRepository->findByUuid($request->category_id);
        // $merchant = $this->merchantRepository->findByUuid($request->merchant_id);

        // $request->merge([
        //     "category_id" => $category->id,
        //     "merchant_id" => $merchant->id
        // ]);

        // $product = $this->repository->create($request->parameters());

        // // $uploadedFiles = [];
        // // $files = $request->file('images');

        // // foreach ($files as $file) {
        // //     // Save each file to the 'uploads' directory and get the path
        // //     $path = $file->store('uploads/products');
        // //     $uploadedFiles[] = $path;
        // // }

        $product = ProductAction::action($request->parameters())
            ->setCategory($request->category_id)
            ->setMerchant($request->merchant_id)
            ->uploadImages($request->file('images'))
            ->create();

        return redirect()->back()
            ->with('code', '200')
            ->with('status', 'success')
            ->with('message', 'Product created successfully!')
            ->with('data', $product);
    }

    /**
     * Display the specified resource.
     */
    public function show(SelectProductRequest $request, string $uuid)
    {
        $filters = [];

        $merchantUuid = $request->query('merchant');
        if (!empty($merchantUuid)) {
            $merchant = $this->merchantRepository->findByUuid($merchantUuid);
            $filters = [
                ['merchant_id', "=", $merchant->id]
            ];
        }

        $product = $this->repository->findByUuid($uuid, ['category', 'merchant', 'images'], [], $filters);
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
        // $merchantUuid = $request->query('merchant');

        // $category = $this->categoryRepository->findByUuid($request->category_id);
        // $merchant = $this->merchantRepository->findByUuid($request->merchant_id);
        // $request->merge([
        //     "category_id" => $category->id,
        //     "merchant_id" => $merchant->id
        // ]);

        // $filters = [];
        // if (!empty($merchantUuid)) {
        //     $merchant = $this->merchantRepository->findByUuid($merchantUuid);
        //     $filters = [
        //         ["merchant_id", "=", $merchant->id]
        //     ];
        // }

        // $product = $this->repository->update($uuid, $request->parameters(), $filters);

        try {
            $product = ProductAction::action($request->parameters())
                ->setUuid($uuid)
                ->setCategory($request->category_id)
                ->setMerchant($request->merchant_id)
                ->uploadImages($request->file('images'))
                ->update();

            return redirect()->back()
                ->with('code', '200')
                ->with('status', 'success')
                ->with('message', 'Product updated successfully!')
                ->with('data', $product);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteProductRequest $request, string $uuid)
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
        
        if (!empty($categoryUuid)) {
            $category = $this->categoryRepository->findByUuid($categoryUuid);
            $filters[] = ['category_id', "=", $category->id];
        }
        if (!empty($stockStatus)) {
            $filters[] = ['stock_status', "LIKE", "%{$stockStatus}%"];
        }

        if ($request->user()?->role->is(UserRoles::MERCHANT)) {
            $uuid = $request->user()->merchantUser->merchant->uuid;
            $merchant = $this->merchantRepository->findByUuid($uuid);
            $filters[] = ['merchant_id', "=", $merchant->id];
        }
        else {
            if (!empty($merchantUuid)) {
                $merchant = $this->merchantRepository->findByUuid($merchantUuid);
                $filters[] = ['merchant_id', "=", $merchant->id];
            }
        }
        
        $data = $this->repository->paginate($request->size ?? 5, $filters);

        return Inertia::render("Admin/Product/ProductList", [
            "merchant_uuid" => "",
            "paginate" => $data,
        ]);
    }

    public function deleteImage(Request $request, string $uuid)
    {
        $this->fileRepository->delete($uuid);

        return redirect()->back()
                ->with('code', '200')
                ->with('status', 'success')
                ->with('message', 'Image deleted successfully!');
    }
}
