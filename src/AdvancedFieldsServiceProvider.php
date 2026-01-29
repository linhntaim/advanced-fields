<?php

namespace LinhntAim\AdvancedFields;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AdvancedFieldsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'advanced-fields';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Css::make('grid-fields', __DIR__ . '/../resources/css/grid-fields.css')->loadedOnRequest(),
        ], 'linhntaim/advanced-fields');
    }
}
