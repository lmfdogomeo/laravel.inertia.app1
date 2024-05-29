<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function query(): Builder
    {
        return Product::query();
    }

    public function all(): Collection
    {
        return $this->query()->all();
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
        return $this->query()
            ->with($relationships)
            ->when(!empty($filters), function($query) use($filters) {
                foreach($filters as $key => $value) {
                    $query->where($value[0], $value[1], $value[2]);
                }
            })
            ->where('uuid', '=', $uuid)->firstOrFail();
    }

    public function paginate(int $size, array $filters = [], array $relationships = [], array $withCounts = []): Paginator
    {
        return $this->query()
            ->when(!empty($filters), function($query) use ($filters) {
                foreach($filters as $key => $value) {
                    $query->where($value[0], $value[1], $value[2]);
                }
            })
            ->paginate($size)->withQueryString();
    }

    public function update(string $uuid, array $data, array $filters = []): Model
    {
        $model = $this->findByUuid($uuid, [], [],$filters);

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