<?php

namespace LinhntAim\AdvancedFields\Support;

trait ArrReduceWithKeys
{
    public static function reduce(array $array, callable $callback, mixed $initial = null): mixed
    {
        $carry = $initial;
        foreach ($array as $key => $value) {
            $carry = $callback($carry, $value, $key);
        }
        return $carry;
    }
}
