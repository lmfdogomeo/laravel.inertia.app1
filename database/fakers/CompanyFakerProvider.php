<?php

namespace Database\Fakers;

use Faker\Provider\Base;

class CompanyFakerProvider extends Base
{
    public function companyTaxId()
    {
        // Generate a random tax ID
        // For example, a format like 'XX-XXXXXXX'
        $prefix = $this->generator->randomElement(['AB', 'BC', 'CD', 'DE', 'EF']);
        $number = $this->generator->numerify('#######');

        return $prefix . '-' . $number;
    }

    public function fourDigitPostalCode()
    {
        // Generate a random 4-digit postal code
        return $this->generator->numerify('####');
    }
}
