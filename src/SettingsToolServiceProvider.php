<?php

declare(strict_types=1);

namespace CodeHeroMX\SettingsTool;

use CodeHeroMX\SettingsTool\Http\Middleware\Authorize;
use CodeHeroMX\SettingsTool\Http\Middleware\SettingsPathExists;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;

class SettingsToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadTranslationsFrom(__DIR__ . '/../lang', 'nova-settings-tool');

        $this->registerTranslations();

        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
    }

    public function register()
    {
        $this->registerRoutes();

        $this->mergeConfigFrom(
            __DIR__ . '/../config/nova-settings-tool.php',
            'nova-settings-tool'
        );

        $this->app->singleton(NovaSettingsStore::class, function () {
            return new NovaSettingsStore();
        });
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/' => config_path(),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../lang' => lang_path('vendor/nova-settings-tool'),
        ], 'translations');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'migrations');
    }

    protected function registerRoutes()
    {
        Nova::router()->group(function ($router) {
            $path = config('nova-settings-tool.base_path', 'nova-settings-tool');

            $router
                ->get("{$path}/{pageId?}", fn ($pageId = 'general') => inertia('SettingsTool', ['basePath' => $path, 'pageId' => $pageId]))
                ->middleware(['nova', Authenticate::class])
                ->domain(config('nova.domain', null));
        });

        if ($this->app->routesAreCached()) return;

        Route::middleware(['nova', Authorize::class, SettingsPathExists::class])
            ->domain(config('nova.domain', null))
            ->group(__DIR__ . '/../routes/api.php');
    }

    protected function registerTranslations()
    {
        Nova::serving(function (ServingNova $event) {
            $currentLocale = app()->getLocale();

            Nova::translations(__DIR__ . '/../lang/' . $currentLocale . '.json');
            Nova::translations(resource_path('lang/vendor/nova-settings-tool/' . $currentLocale . '.json'));
            Nova::translations(lang_path('vendor/nova-settings-tool/' . $currentLocale . '.json'));
        });

        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'SettingsTool');
        $this->loadJSONTranslationsFrom(__DIR__ . '/../lang');
        $this->loadJSONTranslationsFrom(resource_path('lang/vendor/nova-settings-tool'));
        $this->loadJSONTranslationsFrom(lang_path('vendor/nova-settings-tool'));
    }
}
