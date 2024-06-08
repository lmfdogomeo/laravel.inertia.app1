<?php

namespace App\Services\Product\Actions;

use App\Repositories\Contracts\FileRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Product\Traits\InteractWithCategory;
use App\Services\Product\Traits\InteractWithMerchant;
use App\Traits\HasUuidSetter;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreAction
{
    use InteractWithCategory;
    use InteractWithMerchant;
    use HasUuidSetter;

    protected readonly ProductRepositoryInterface $productRepository;
    protected readonly FileRepositoryInterface $fileRepository;
    private $images = [];
    public function __construct(protected $parameters)
    {
        $this->productRepository = app(ProductRepositoryInterface::class);
        $this->fileRepository = app(FileRepositoryInterface::class);
    }

    public function create()
    {
        $this->parameters = array_merge($this->parameters, [
            'category_id' => $this->categoryId,
            'merchant_id' => $this->merchantId,
        ]);

        DB::beginTransaction();
        try {
            $product = $this->productRepository->create($this->parameters);

            $fileToInsertData = [];
            foreach($this->images as $key => $image) {
                $fileToInsertData[] = [
                    'uuid' => (string) Str::uuid(),
                    'image_path' => $image,
                    'product_id' => $product->id,
                    'main_display' => $key === 0
                ];
            }

            $fileData = $this->fileRepository->createMany($fileToInsertData);

            Log::channel('error')->error('Sample Create', [
                'fileData' => $fileData,
                'product' => $product,
                'images' => $this->images,
                'categoryId' => $this->categoryId,
                'merchantId' => $this->merchantId,
                'parameters' => $this->parameters,
            ]);


            if (!$fileData) {
                DB::rollBack();

                Storage::delete($this->images);

                throw new Exception("Failed to save product images.");
            }

            DB::commit();

        } catch (\Exception $e) {
            Storage::delete($this->images);
            DB::rollBack();
            Log::channel('error')->error('Exception Error', [
                'message' => $e->getMessage()
            ]);

            throw new Exception($e->getMessage());
        }
    }

    public function update()
    {
        $this->parameters = array_merge($this->parameters, [
            'category_id' => $this->categoryId,
            'merchant_id' => $this->merchantId,
        ]);

        DB::beginTransaction();
        try {
            $product = $this->productRepository->update($this->getUuid(), $this->parameters);

            $fileToInsertData = [];
            foreach($this->images as $key => $image) {
                $fileToInsertData[] = [
                    'uuid' => (string) Str::uuid(),
                    'image_path' => $image,
                    'product_id' => $product->id,
                    'main_display' => $key === 0
                ];
            }

            $fileData = $this->fileRepository->createMany($fileToInsertData);

            if (!$fileData) {
                DB::rollBack();

                Storage::delete($this->images);

                throw new Exception("Failed to save product images.");
            }

            DB::commit();

        } catch (\Exception $e) {
            Storage::delete($this->images);
            DB::rollBack();
            Log::channel('error')->error('Exception Error', [
                'message' => $e->getMessage()
            ]);

            throw new Exception($e->getMessage());
        }
    }

    public function uploadImages(mixed $images)
    {
        if (!empty($images)) {
            foreach ($images as $file) {
                $uploaded = $file->store('products', 'public');
                $this->images[] = Storage::disk("public")->url($uploaded);
            }
        }

        return $this;
    }
}
