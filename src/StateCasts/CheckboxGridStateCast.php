<?php

namespace LinhntAim\AdvancedFields\StateCasts;

class CheckboxGridStateCast extends GridStateCast
{
    protected function getWhenArray(array $stateItem): array
    {
        $values = [];
        foreach ($stateItem as $key => $value) {
            if ((is_int($key) && is_string($value))
                || (is_string($key) && is_bool($value) && $value)) {
                $values[] = $value;
            }
        }
        return $values;
    }

    protected function setWhenArray(array $stateItem): array
    {
        $values = [];
        foreach ($stateItem as $key => $value) {
            if (is_int($key) && is_string($value)) {
                $values[$value] = true;
            }
            elseif (is_string($key) && is_bool($value)) {
                $values[$key] = $value;
            }
        }
        return $values;
    }
}
