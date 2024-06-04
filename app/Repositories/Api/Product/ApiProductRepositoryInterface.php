<?php

namespace App\Repositories\Api\Product;

use App\Repositories\Api\ApiRepositoryContract;
use App\Repositories\Contracts\PaginateRepositoryInterface;

interface ApiProductRepositoryInterface extends ApiRepositoryContract, PaginateRepositoryInterface
{
    public function dataPerMonthByYear(string $year): array;
    public function where(mixed $column);
    public function count(int $merchantId): int;
}