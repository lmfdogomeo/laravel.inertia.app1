<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface FileRepositoryInterface extends RepositoryInterface, PaginateRepositoryInterface
{
    public function createMany(array $data): bool;
}