<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function query(): Builder;

    public function all(): Collection;

    public function find(int $id): Model;

    public function findByUuid(string $uuid, array $relationships = [], array $withCounts = [], array $filters = []): Model;

    public function create(array $data): Model;

    public function update(string $uuid, array $data, array $filters = []): Model;

    public function delete(string $uuid, array $filters = []): Model;

    public function count(): int;
}