<?php

namespace Mansoor\FilamentSocialWall;

use Livewire\Livewire;
use Filament\PluginServiceProvider;
use Mansoor\FilamentSocialWall\Http\Livewire\SocialWall;
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

    // TODO: remove/cleanup at the end if not required
    // protected array $scripts = [
    //     'plugin-filament-social-wall' => __DIR__ . '/../resources/dist/filament-social-wall.js',
    // ];

    // TODO: remove/cleanup at the end if not required
    // protected array $beforeCoreScripts = [
    //     'plugin-filament-social-wall' => __DIR__ . '/../resources/dist/filament-social-wall.js',
    // ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasMigration('create_social_providers_table')
            ->hasViews('filament-social-wall')
            ->hasRoute('filament-social-wall');
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        Livewire::component('social-wall', SocialWall::class);
    }
}
