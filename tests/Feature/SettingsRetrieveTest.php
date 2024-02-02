<?php

namespace CodeHeroMX\SettingsTool\Tests\Feature;

use Laravel\Nova\Fields\Text;
use CodeHeroMX\SettingsTool\SettingsTool;
use CodeHeroMX\SettingsTool\Tests\IntegrationTestCase;

class SettingsRetrieveTest extends IntegrationTestCase
{
    public function test_general_fields_are_returned_with_no_path()
    {
        SettingsTool::addSettingsFields([
            Text::make('Test'),
            Text::make('TestOne'),
        ]);

        SettingsTool::addSettingsFields([
            Text::make('TestTwo'),
            Text::make('TestThree'),
            Text::make('TestFour'),
        ], [], 'Other');

        $request = $this->getJson(route('nova-settings-tool.get'));

        $request->assertStatus(200);
        $request->assertJsonCount(2, 'fields');
    }

    public function test_general_fields_are_returned_with_general_path()
    {
        SettingsTool::addSettingsFields([
            Text::make('Test'),
            Text::make('TestOne'),
        ]);

        SettingsTool::addSettingsFields([
            Text::make('TestTwo'),
            Text::make('TestThree'),
            Text::make('TestFour'),
        ], [], 'Other');

        $request = $this->getJson(route('nova-settings-tool.get', ['path' => 'general']));

        $request->assertStatus(200);
        $request->assertJsonCount(2, 'fields');
    }

    public function test_other_fields_are_returned_with_other_path()
    {
        SettingsTool::addSettingsFields([
            Text::make('Test'),
            Text::make('TestOne'),
        ]);

        SettingsTool::addSettingsFields([
            Text::make('TestTwo'),
            Text::make('TestThree'),
            Text::make('TestFour'),
        ], [], 'Other');

        $request = $this->getJson(route('nova-settings-tool.get', ['path' => 'other']));

        $request->assertStatus(200);
        $request->assertJsonCount(3, 'fields');
    }
}
