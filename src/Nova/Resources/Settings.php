<?php

namespace CodeHeroMX\SettingsTool\Nova\Resources;

use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use CodeHeroMX\SettingsTool\SettingsTool;

class Settings extends Resource
{
    public static $title = 'key';
    public static $model = null;
    public static $displayInNavigation = false;

    public function __construct($resource)
    {
        self::$model = SettingsTool::getSettingsModel();
        parent::__construct($resource);
    }

    public function fields(Request $request)
    {
        return [];
    }
}
