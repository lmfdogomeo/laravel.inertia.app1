<?php

namespace App\Repositories;

use App\Models\ProductCategory;
use App\Repositories\Contracts\ProductCategoryRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface
{
    public function query(): Builder
    {
        return ProductCategory::query();
    }

    public function all(): Collection
    {
        return $this->query()->get();
    }

    public function create(array $data): Model
    {
        return $this->query()->create($data);
    }

    public function find(int $id): Model
    {
        return $this->query()->findOrFail($id);
    }

    public function findByUuid(string $uuid, array $relationships = [], array $withCounts = [], array $filters = []): Model
    {
        return $this->query()->where('uuid', '=', $uuid)->firstOrFail();
    }

    public function paginate(int $size, array $filters = [], array $relationships = [], array $withCounts = []): Paginator
    {
        return $this->query()->paginate($size);
    }

    public function update(string $uuid, array $data, array $filters = []): Model
    {
        $model = $this->query()->findByUuid($uuid);

        $model->update($data);

        return $model;
    }

    public function delete(string $uuid, array $filters = []): Model
    {
        $model = $this->findByUuid($uuid, [], [], $filters);

        $model->delete();

        return $model;
    }
}