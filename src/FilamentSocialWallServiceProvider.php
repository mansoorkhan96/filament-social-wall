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
        ConnectSocialMediaWidget::class,
    ];

    protected array $styles = [
        'plugin-filament-social-wall' => __DIR__.'/../resources/dist/filament-social-wall.css',
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasMigration('create_social_providers_table')
            ->hasViews('filament-social-wall')
            ->hasRoute('filament-social-wall');
    }
}
