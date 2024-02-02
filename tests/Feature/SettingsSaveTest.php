<?php

namespace CodeHeroMX\SettingsTool\Tests\Feature;

use Laravel\Nova\Fields\Text;
use CodeHeroMX\SettingsTool\SettingsTool;
use CodeHeroMX\SettingsTool\Models\Settings;
use CodeHeroMX\SettingsTool\Tests\IntegrationTestCase;

class SettingsSaveTest extends IntegrationTestCase
{
    public function test_settings_are_saved()
    {
        SettingsTool::addSettingsFields([
            Text::make('Test'),
            Text::make('TestOne'),
        ]);

        $request = $this->postJson(route('nova-settings-tool.save'), ['test' => 'Test Value']);

        $request->assertStatus(204);
        $this->assertEquals('Test Value', Settings::getValueForKey('test'));
    }

    public function test_settings_are_saved_with_path()
    {
        SettingsTool::addSettingsFields([
            Text::make('TestTwo'),
            Text::make('TestThree'),
            Text::make('TestFour'),
        ], [], 'Other');

        $request = $this->postJson(route('nova-settings-tool.save'), ['path' => 'other', 'testthree' => 'Test Value']);

        $request->assertStatus(204);
        $this->assertEquals('Test Value', Settings::getValueForKey('testthree'));
    }
}
