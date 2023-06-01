<?php

namespace Mansoor\FilamentSocialWall;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentSocialWallServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-social-wall';

    protected array $resources = [
        // CustomResource::class,
    ];

    protected array $pages = [
        // CustomPage::class,
    ];

    protected array $widgets = [
        // CustomWidget::class,
    ];

    protected array $styles = [
        'plugin-filament-social-wall' => __DIR__.'/../resources/dist/filament-social-wall.css',
    ];

    protected array $scripts = [
        'plugin-filament-social-wall' => __DIR__.'/../resources/dist/filament-social-wall.js',
    ];

    // protected array $beforeCoreScripts = [
    //     'plugin-filament-social-wall' => __DIR__ . '/../resources/dist/filament-social-wall.js',
    // ];

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);
    }
}
