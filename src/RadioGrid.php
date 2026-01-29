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
use LinhntAim\AdvancedFields\Concerns\HasClearButton;
use LinhntAim\AdvancedFields\Concerns\SupportsGrid;

class RadioGrid extends Field implements ICanDisableOptions, IHasNestedRecursiveValidationRules
{
    use CanDisableOptions;
    use CanDisableOptionsWhenSelectedInSiblingRepeaterItems;
    use HasOptions;
    use SupportsGrid;
    use HasClearButton;
    use HasNestedRecursiveValidationRules;
    use HasExtraInputAttributes;

    protected string $view = 'advanced-fields::radio-grid';

    protected function setUp(): void
    {
        parent::setUp();

        $this->mutateStateForValidationUsing(function (array $state) {
            $count = count($state);
            if ($count > 0 && $count !== count($rows = $this->getRows())) {
                $state = array_merge(array_fill_keys(array_keys($rows), null), $state);
            }
            return $state;
        });
    }
}
