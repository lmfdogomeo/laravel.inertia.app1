<?php 

namespace App\Enums;

use App\Enums\Concerns\Conditions;
use App\Enums\Concerns\Options;
use App\Enums\Concerns\Values;

enum ProductUnits: string
{
    use Conditions, Values, Options;
    
    case PIECES = "pieces";
    case BOXES = "boxes";
    case KG = "kilograms";
    case PACK = "pack";
    case BUNDLE = "bundle";
    case DOZEN = "dozen";
}