<?php

namespace App\Services\Product\Traits;

use App\Repositories\Contracts\ProductCategoryRepositoryInterface;

trait InteractWithCategory
{
    protected int $categoryId;

    public function setCategory(string $categoryUuid): static
    {
        $category = app(ProductCategoryRepositoryInterface::class)->findByUuid($categoryUuid);

        $this->categoryId = $category->id;

        return $this;
    }
}
