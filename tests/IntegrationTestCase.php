<?php

namespace CodeHeroMX\SettingsTool\Tests;

use Laravel\Nova\Nova;
use Laravel\Nova\NovaServiceProvider;
use Illuminate\Support\Facades\Route;
use CodeHeroMX\SettingsTool\SettingsTool;
use Orchestra\Testbench\TestCase as Orchestra;
use CodeHeroMX\SettingsTool\SettingsToolServiceProvider;

abstract class IntegrationTestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        SettingsTool::clearFields();
        Route::middlewareGroup('nova', []);
        Nova::$tools = [
            new SettingsTool,
        ];

        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            NovaServiceProvider::class,
            SettingsToolServiceProvider::class,
        ];
    }

    protected function setUpDatabase()
    {
        $this->artisan('migrate:fresh');
    }
}
