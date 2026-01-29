<?php

namespace LinhntAim\AdvancedFields\Concerns;

use Closure;
use Filament\Schemas\Components\StateCasts\Contracts\StateCast;
use Illuminate\Contracts\Support\Arrayable;
use LinhntAim\AdvancedFields\StateCasts\GridStateCast;

trait SupportsGrid
{
    protected array|Closure|Arrayable|null $rows;

    /**
     * @var class-string<StateCast>
     */
    protected string $gridStateCast = GridStateCast::class;

    public function rows(array|Closure|Arrayable|null $rows): static
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * @return array
     */
    public function getRows(): array
    {
        $rows = $this->evaluate($this->rows) ?? [];

        if ($rows instanceof Arrayable) {
            $rows = $rows->toArray();
        }

        return $rows;
    }

    /**
     * @return class-string<StateCast>
     */
    public function getGridStateCast(): string
    {
        return $this->gridStateCast;
    }

    /**
     * @return array<StateCast>
     */
    public function getDefaultStateCasts(): array
    {
        if ($this->hasCustomStateCasts() || filled($this->getEnum())) {
            return parent::getDefaultStateCasts();
        }

        return [app($this->getGridStateCast())];
    }

    public function hasInValidationOnMultipleValues(): bool
    {
        return true;
    }

    /**
     * @return ?array<string>
     */
    public function getInValidationRuleValues(): ?array
    {
        $values = parent::getInValidationRuleValues();

        if ($values !== null) {
            return $values;
        }

        if (method_exists($this, 'getEnabledOptions')) {
            return array_keys($this->getEnabledOptions());
        }

        return null;
    }

    public function hasMultipleValuesOnEachRow(): bool
    {
        return false;
    }

    public function dehydrateValidationRules(array &$rules): void
    {
        parent::dehydrateValidationRules($rules);

        $statePath = $this->getStatePath();
        $rules["$statePath.*"] = [
            ...($this->hasMultipleValuesOnEachRow() ? ['array'] : []),
            ...($this->isRequired() ? ['required'] : ['nullable']),
            ...$rules["$statePath.*"] ?? [],
        ];
    }
}
