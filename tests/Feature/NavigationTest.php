<?php

namespace CodeHeroMX\SettingsTool\Tests\Feature;

use Laravel\Nova\Fields\Text;
use CodeHeroMX\SettingsTool\SettingsTool;
use CodeHeroMX\SettingsTool\Tests\IntegrationTestCase;

class NavigationTest extends IntegrationTestCase
{
    public function test_general_navigation_renders_with_no_fields()
    {
        $settingsTool = new SettingsTool;
        $navigationView = $settingsTool->renderNavigation()->render();
        $this->assertStringContainsString('dusk="nova-settings-tool"', $navigationView);
    }

    public function test_general_navigation_renders_with_fields()
    {
        SettingsTool::addSettingsFields([
            Text::make('Test'),
        ]);

        $settingsTool = new SettingsTool;
        $navigationView = $settingsTool->renderNavigation()->render();

        $this->assertStringContainsString('dusk="nova-settings-tool"', $navigationView);
    }

    public function test_multiple_navigation_renders()
    {
        SettingsTool::addSettingsFields([
            Text::make('Test'),
        ]);

        SettingsTool::addSettingsFields([
            Text::make('TestTwo'),
        ], [], 'Other');

        $settingsTool = new SettingsTool;
        $navigationView = $settingsTool->renderNavigation()->render();

        $this->assertStringContainsString('dusk="nova-settings-tool-general"', $navigationView);
        $this->assertStringContainsString('dusk="nova-settings-tool-other"', $navigationView);
    }
}
