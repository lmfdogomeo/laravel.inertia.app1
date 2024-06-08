<?php 

namespace App\Services\Product;

use App\Services\Product\Actions\StoreAction;

class Action
{
    public function action(array $parameters): StoreAction
    {
        return (new StoreAction($parameters));
    }
}