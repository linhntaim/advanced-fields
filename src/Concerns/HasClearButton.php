<?php

namespace LinhntAim\AdvancedFields\Concerns;

use Closure;
use Illuminate\Contracts\Support\Htmlable;

trait HasClearButton
{
    public static string $defaultClearButtonLabel = 'Clear selection';

    protected string|Htmlable|Closure|null $clearButtonLabel = null;

    public function clearButtonLabel(string|Htmlable|Closure|null $label): static
    {
        $this->clearButtonLabel = $label;
        return $this;
    }

    public function getClearButtonLabel(): string|Htmlable
    {
        return $this->evaluate($this->clearButtonLabel) ?? static::$defaultClearButtonLabel;
    }
}
