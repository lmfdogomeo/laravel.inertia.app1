<?php

namespace App\Traits;

trait HasUuidSetter {
    protected string $uuid;
    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
