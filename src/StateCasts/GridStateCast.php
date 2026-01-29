<?php

namespace LinhntAim\AdvancedFields\StateCasts;

use BackedEnum;
use Filament\Schemas\Components\StateCasts\OptionsArrayStateCast;
use LinhntAim\AdvancedFields\Support\Arr;

class GridStateCast extends OptionsArrayStateCast
{
    /**
     * @return array<string | int>
     */
    public function get(mixed $state): array
    {
        if (blank($state)) {
            return [];
        }

        if (!is_array($state)) {
            $state = json_decode($state, associative: true);
        }

        return Arr::reduce(
            Arr::wrap($state),
            function (array $carry, $stateItem, $rowValue): array {
                if (blank($stateItem)) {
                    return $carry;
                }

                if ($stateItem instanceof BackedEnum) {
                    $stateItem = $stateItem->value;
                }

                if (
                    is_int($stateItem)
                    || (
                        is_string($stateItem)
                        && ctype_digit($stateItem)
                        && (($stateItem === '0') || (!str($stateItem)->startsWith('0')))
                    )
                ) {
                    $max = (string)PHP_INT_MAX;

                    if (
                        (strlen($stateItem) > strlen($max)) ||
                        ((strlen($stateItem) === strlen($max)) && (strcmp($stateItem, $max) > 0))
                    ) {
                        $carry[$rowValue] = strval($stateItem);
                    }
                    else {
                        $carry[$rowValue] = intval($stateItem);
                    }
                }
                elseif (is_array($stateItem)) {
                    $carry[$rowValue] = $this->getWhenArray($stateItem);
                }
                else {
                    $carry[$rowValue] = strval($stateItem);
                }

                return $carry;
            },
            initial: [],
        );
    }

    protected function getWhenArray(array $stateItem): array
    {
        return $stateItem;
    }

    /**
     * @return array<string>
     */
    public function set(mixed $state): array
    {
        if (blank($state)) {
            return [];
        }

        if (!is_array($state)) {
            $state = json_decode($state, associative: true);
        }

        return Arr::reduce(
            Arr::wrap($state),
            function (array $carry, $stateItem, $rowValue): array {
                if (blank($stateItem)) {
                    return $carry;
                }

                if ($stateItem instanceof BackedEnum) {
                    $stateItem = $stateItem->value;
                }

                if (is_array($stateItem)) {
                    $carry[$rowValue] = $this->setWhenArray($stateItem);
                }
                else {
                    $carry[$rowValue] = strval($stateItem);
                }

                return $carry;
            },
            initial: [],
        );
    }

    protected function setWhenArray(array $stateItem): array
    {
        return $stateItem;
    }
}
