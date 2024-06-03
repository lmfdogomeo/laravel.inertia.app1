<?php

namespace App\Repositories;

use App\Models\MerchantUser;
use App\Models\User;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;

class AccountRepository extends BaseRepository implements AccountRepositoryInterface
{
    private $query;

    public function __construct()
    {
        $this->query = User::query();
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
        $this->startDbTransaction();

        $user = $this->query->create($data);

        if (!$user->save()) {
            $this->rollbackDbTransaction();

            throw new Exception("Failed to save user account");
        }

        $merchantUser = MerchantUser::create([
            "user_id" => $user->id,
            "merchant_id" => $data['merchant_id']
        ]);

        if (!$merchantUser->save()) {
            $this->rollbackDbTransaction();

            throw new Exception("Failed to link user and merchant account");
        }

        $this->commitDbTransaction();

        return $user;
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
        ->when(!empty($relationships), function($query) use($relationships) {
            $query->with($relationships);
        })
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