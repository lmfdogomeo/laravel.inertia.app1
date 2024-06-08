<?php

namespace App\Services\Product\Traits;

use App\Repositories\Contracts\MerchantRepositoryInterface;

trait InteractWithMerchant
{
    protected int $merchantId;

    public function setMerchant(string $merchantUuid): static
    {
        $merchant = app(MerchantRepositoryInterface::class)->findByUuid($merchantUuid);

        $this->merchantId = $merchant->id;

        return $this;
    }
}
