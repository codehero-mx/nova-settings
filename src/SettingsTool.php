<?php

namespace CodeHeroMX\SettingsTool;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use CodeHeroMX\SettingsTool\Models\Settings;

class SettingsTool extends Tool
{
    public function boot()
    {
        Nova::script('nova-settings-tool', __DIR__ . '/../dist/js/entry.js');
    }

    public function menu(Request $request)
    {
        $fields = static::getFields();
        $basePath = config('nova-settings-tool.base_path', 'nova-settings-tool');
        $isAuthorized = static::canSeeSettings();
        $showInSidebar = config('nova-settings-tool.show_in_sidebar', true);

        if (!$isAuthorized || !$showInSidebar || empty($fields)) return null;

        if (count($fields) == 1) {

            return MenuSection::make(__('settingsTool.navigationItemTitle'))
                ->path($basePath . '/' . array_key_first($fields))
                ->icon('adjustments');
        } else {
            $menuItems = [];
            foreach ($fields as $key => $fields) {
                $menuItems[] = MenuItem::link(self::getPageName($key), "{$basePath}/{$key}");
            }

            return MenuSection::make(__('settingsTool.navigationItemTitle'), $menuItems)
                ->icon('adjustments')
                ->collapsable();
        }
    }

    public static function getSettingsTableName(): string
    {
        return config('nova-settings-tool.table', 'nova_settings');
    }

    public static function getPageName($key): string
    {
        if (__("settingsTool.$key") === "settingsTool.$key") {
            return Str::title(str_replace('-', ' ', $key));
        } else {
            return __("settingsTool.$key");
        }
    }

    public static function getAuthorizations($key = null)
    {
        $request = request();
        $fakeResource = new \CodeHeroMX\SettingsTool\Nova\Resources\Settings(SettingsTool::getSettingsModel()::make());

        $authorizations = [
            'authorizedToView' => $fakeResource->authorizedToView($request),
            'authorizedToCreate' => $fakeResource->authorizedToCreate($request),
            'authorizedToUpdate' => $fakeResource->authorizedToUpdate($request),
            'authorizedToDelete' => $fakeResource->authorizedToDelete($request),
        ];

        return $key ? $authorizations[$key] : $authorizations;
    }

    public static function canSeeSettings()
    {
        $auths = static::getAuthorizations();
        return $auths['authorizedToView'] || $auths['authorizedToUpdate'];
    }

    /**
     * Define settings fields and an optional casts.
     *
     * @param array|callable $fields Array of fields/panels to be displayed or callable that returns an array.
     * @param array $casts Associative array same as Laravel's $casts on models.
     **/
    public static function addSettingsFields($fields = [], $casts = [], $path = 'general')
    {
        return static::getStore()->addSettingsFields($fields, $casts, $path);
    }

    /**
     * Define casts.
     *
     * @param array $casts Casts same as Laravel's casts on a model.
     **/
    public static function addCasts($casts = [])
    {
        return static::getStore()->addCasts($casts);
    }

    public static function getFields($path = null)
    {
        if (!$path) return static::getStore()->getRawFields();
        return static::getStore()->getFields($path);
    }

    public static function clearFields()
    {
        return static::getStore()->clearFields();
    }

    public static function getCasts()
    {
        return static::getStore()->getCasts();
    }

    public static function getSetting($settingKey, $default = null)
    {
        return static::getStore()->getSetting($settingKey, $default);
    }

    public static function getSettings(array $settingKeys = null, array $defaults = [])
    {
        return static::getStore()->getSettings($settingKeys, $defaults);
    }

    public static function setSettingValue($settingKey, $value = null)
    {
        return static::getStore()->setSettingValue($settingKey, $value);
    }

    public static function getSettingsModel(): string
    {
        return config('nova-settings-tool.models.settings', Settings::class);
    }

    public static function doesPathExist($path)
    {
        return array_key_exists($path, static::getFields());
    }

    public static function getStore(): NovaSettingsStore
    {
        return app()->make(NovaSettingsStore::class);
    }
}
