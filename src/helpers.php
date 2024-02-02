<?php

use CodeHeroMX\SettingsTool\SettingsTool;

if (!function_exists('nova_get_settings')) {
    function nova_get_settings($settingKeys = null, $defaults = [])
    {
        return SettingsTool::getSettings($settingKeys, $defaults);
    }
}

if (!function_exists('nova_get_setting')) {
    function nova_get_setting($settingKey, $default = null)
    {
        return SettingsTool::getSetting($settingKey, $default);
    }
}

if (!function_exists('nova_set_setting_value')) {
    function nova_set_setting_value($settingKey, $value = null)
    {
        return SettingsTool::setSettingValue($settingKey, $value);
    }
}
