<?php

namespace App\Repositories\Contracts;

interface AccountRepositoryInterface extends RepositoryInterface, PaginateRepositoryInterface
{
    public function dataPerMonthByYear(string $year);
}