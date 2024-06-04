<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface extends RepositoryInterface, PaginateRepositoryInterface
{
    public function dataPerMonthByYear(string $year);
    public function where(mixed $column);
}