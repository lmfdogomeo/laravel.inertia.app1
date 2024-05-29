<?php 

namespace App\Enums;

use App\Enums\Concerns\Conditions;
use App\Enums\Concerns\Options;
use App\Enums\Concerns\Values;

enum StockStatus: string
{
    use Conditions, Values, Options;
    
    case IN_STOCK = "in stock";
    case LOW_INVENTORY = "low inventory";
    case OUT_OF_STOCK = "out of stock";
    case ON_DEMAND = "on demand";
    case TEMPORARY_UNAVAILABLE = "temporary unavailable";
}