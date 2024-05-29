<?php

namespace App\Http\Requests\Concerns;


trait RequestHelpers
{
    public function uuid(): string
    {
        return $this->route('uuid');
    }
}
