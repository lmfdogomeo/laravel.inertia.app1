<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    private $query;

    public function __construct()
    {
        $this->query = Product::query();
    }
    
    public function query(): Builder
    {
        return $this->query;
    }

    public function all(): Collection
    {
        return $this->query->all();
    }

    public function create(array $data): Model
    {
        return $this->query()->create($data);
    }

    public function find(int $id): Model
    {
        return $this->query->findOrFail($id);
    }

    public function findByUuid(string $uuid, array $relationships = [], array $withCounts = [], array $filters = []): Model
    {
        return $this->query
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
        return $this->query
            ->when(!empty($filters), function($query) use ($filters) {
                foreach($filters as $key => $value) {
                    $query->where($value[0], $value[1], $value[2]);
                }
            })
            ->paginate($size)
            ->withQueryString();
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

    public function count(): int
    {
        $data = $this->query->count();

        return $data;
    }

    public function dataPerMonthByYear($year, $merchantId = null)
    {
        $totals = $this->query->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->when(!empty($merchantId), function($query) use($merchantId) {
                $query->where('merchant_id', "=", $merchantId);
            })
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Initialize an array with 0 for each month
        $monthlyTotals = array_fill(1, 12, 0);

        // Merge the results with the initialized array
        foreach ($totals as $month => $total) {
            $monthlyTotals[$month] = $total;
        }

        return $monthlyTotals;
    }

    public function where($column)
    {
        $this->query->where($column);

        return $this;
    }
}