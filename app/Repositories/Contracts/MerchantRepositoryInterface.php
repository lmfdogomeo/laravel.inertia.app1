<?php

namespace App\Repositories\Contracts;

interface MerchantRepositoryInterface extends RepositoryInterface, PaginateRepositoryInterface
{
    public function search(mixed $filter);

    public function apiSearch(mixed $filter);
}