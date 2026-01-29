<?php

namespace LinhntAim\AdvancedFields;

use Filament\Forms\Components\Concerns\CanDisableOptions;
use Filament\Forms\Components\Concerns\CanDisableOptionsWhenSelectedInSiblingRepeaterItems;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Concerns\HasNestedRecursiveValidationRules;
use Filament\Forms\Components\Concerns\HasOptions;
use Filament\Forms\Components\Contracts\CanDisableOptions as ICanDisableOptions;
use Filament\Forms\Components\Contracts\HasNestedRecursiveValidationRules as IHasNestedRecursiveValidationRules;
use Filament\Forms\Components\Field;
use LinhntAim\AdvancedFields\Concerns\SupportsGrid;
use LinhntAim\AdvancedFields\StateCasts\CheckboxGridStateCast;

class CheckboxGrid extends Field implements ICanDisableOptions, IHasNestedRecursiveValidationRules
{
    use CanDisableOptions;
    use CanDisableOptionsWhenSelectedInSiblingRepeaterItems;
    use HasOptions;
    use SupportsGrid;
    use HasNestedRecursiveValidationRules;
    use HasExtraInputAttributes;

    protected string $view = 'advanced-fields::checkbox-grid';

    protected function setUp(): void
    {
        parent::setUp();

        $this->mutateStateForValidationUsing(function (array $state) {
            $state = array_filter(
                array_map(function ($checkStates) {
                    $values = [];
                    foreach ($checkStates as $value => $checkState) {
                        if ($checkState) {
                            $values[] = $value;
                        }
                    }
                    return $values;
                }, $state),
                function ($values) {
                    return !empty($values);
                },
            );

            $count = count($state);
            if ($count > 0 && $count !== count($rows = $this->getRows())) {
                $state = array_merge(array_fill_keys(array_keys($rows), []), $state);
            }

            return $state;
        });
    }

    public function getGridStateCast(): string
    {
        return CheckboxGridStateCast::class;
    }

    public function hasMultipleValuesOnEachRow(): bool
    {
        return true;
    }
}
