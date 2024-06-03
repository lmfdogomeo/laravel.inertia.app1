<?php

namespace App\Repositories;

use App\Models\Merchant;
use App\Repositories\Contracts\MerchantRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;

class MerchantRepository implements MerchantRepositoryInterface
{
    private $query;

    public function __construct()
    {
        $this->query = Merchant::query();
    }

    public function query(): Builder
    {
        return $this->query;
    }

    public function all(): Collection
    {
        return $this->query->get();
    }

    public function create(array $data): Model
    {
        return $this->query->create($data);
    }

    public function find(int $id): Model
    {
        return $this->query->findOrFail($id);
    }

    public function findByUuid(string $uuid, array $relationships = [], array $withCounts = [], array $filters = []): Model
    {
        return $this->query->with($relationships)->withCount($withCounts)->where('uuid', '=', $uuid)->firstOrFail();
    }

    public function paginate(int $size, array $filters = [], array $relationships = [], array $withCounts = []): Paginator
    {
        return $this->query
        ->when(!empty($withCounts), function($query) use($withCounts) {
            $query->withCount($withCounts);
        })
        ->paginate($size);
    }

    public function update(string $uuid, array $data, array $filters = []): Model
    {
        $model = $this->findByUuid($uuid);

        $model->update($data);

        return $model;
    }

    public function delete(string $uuid, array $filters = []): Model
    {
        $model = $this->findByUuid($uuid);

        $model->delete();

        return $model;
    }

    public function where($column)
    {
        $this->query->where($column);

        return $this;
    }

    public function search(mixed $filter): Model
    {
        $data = $this->query->where($filter)->firstOrFail();

        return $data;
    }

    public function apiSearch(mixed $filter): ?Model
    {
        $data = $this->query->where($filter)->first();
        // $data = $this->query()->where("company_tax_id", "=", "COM-1234-BB")->first();

        return $data;
    }

    public function count(): int
    {
        $data = $this->query->count();

        return $data;
    }

    public function dataPerMonthByYear($year)
    {
        $totals = $this->query->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
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
}