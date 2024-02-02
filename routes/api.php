<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::namespace('\CodeHeroMX\SettingsTool\Http\Controllers')->group(function () {
    Route::prefix('nova-vendor/nova-settings-tool')->group(function () {
        Route::get('/settings', 'SettingsController@get')
            ->name('nova-settings-tool.get');
        Route::post('/settings', 'SettingsController@save')
            ->name('nova-settings-tool.save');
    });

    Route::delete('/nova-api/nova-settings-tool/{path}/field/{fieldName}', 'SettingsController@deleteImage');
});
