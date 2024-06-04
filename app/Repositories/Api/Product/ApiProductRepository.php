<?php

namespace App\Repositories\Api\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ApiProductRepository extends BaseRepository implements ApiProductRepositoryInterface
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
        return $this->query->get();
    }

    public function find(int $id): ?Model
    {
        return $this->query->find($id);
    }

    public function findByUuid(string $uuid, array $relationships = [], array $withCounts = [], array $filters = []): ?Model
    {
        return $this->query
            ->when(!empty($filters), function($query) use($filters) {
                foreach($filters as $key => $value) {
                    $query->where($value[0], $value[1], $value[2]);
                }
            })
            ->where("uuid", "=", $uuid)->first();
    }

    public function paginate(int $size, array $filters = [], array $relationships = [], array $withCounts = []): Paginator
    {
        return $this->query
            ->when(!empty($filters), function($query) use($filters) {
                foreach($filters as $key => $value) {
                    $query->where($value[0], $value[1], $value[2]);
                }
            })
            ->paginate($size);
    }

    public function create(array $data): ?Model
    {
        return $this->query->create($data);
    }

    public function update(string $uuid, array $data, array $filters = []): ?Model
    {
        $model = $this->findByUuid($uuid);

        if ($model) {
            $model->update($data);

            return $model;
        }

        return null;
    }

    public function delete(string $uuid, array $filters = []): ?Model
    {
        $model = $this->findByUuid($uuid);

        if ($model) {
            $model->delete();

            return $model;
        }

        return null;
    }

    public function count(int $merchantId = null): int
    {
        $data = $this->query->when(!empty($merchantId), function($query) use($merchantId) {
            $query->where('merchant_id', "=", $merchantId);
        })->count();

        return $data;
    }

    public function dataPerMonthByYear($year, $merchantId = null): array
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

    public function execute()
    {
        return $this->query->toSql();
        // return $this->query()->where('product_name', "=", "test", 'brand_name', "=", "sample")->toSql();
        // return $this->query()->where(["product_name" => ["product_name", "=", "sample"], "brand_name" => ["brand_name", "=", "test"]])->toSql();
    }
}
