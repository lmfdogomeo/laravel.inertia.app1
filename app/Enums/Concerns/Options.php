<?php

namespace App\Enums\Concerns;

use BackedEnum;

trait Options
{
    public static function options(): array
    {
        $cases = static::cases();

        $options = isset($cases[0]) && $cases[0] instanceof BackedEnum
            ? array_column($cases, 'name', 'value')
            : array_column($cases, 'name');

        if (isset($cases[0]) && $cases[0] instanceof BackedEnum) {
            $options = array_map(function($option) {
                return ucwords(str_replace('_', ' ', strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $option))));
            }, $options);
        }
        return $options;
    }
}
