<?php

namespace CodeHeroMX\SettingsTool\Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use CodeHeroMX\SettingsTool\Tests\DuskTestCase;

class DetailTest extends DuskTestCase
{
    public function test_settings_appears_in_sidebar_with_no_fields()
    {
        $this->setupLaravel();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('nova');

            dump($browser->element('*')->getAttribute('innerHTML'));

            $browser
                ->assertSee('Settings');

            $browser->blank();
        });
    }

    public function test_settings_appears_in_sidebar_with_fields()
    {
        $this->setupLaravel();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('nova')
                ->assertSee('Settings');

            $browser->blank();
        });
    }

    public function test_can_navigate_into_and_render_settings()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('nova')
                ->assertVisible('@nova-settings-tool')
                ->pause(1500)
                ->click('@nova-settings-tool')
                ->waitFor('@nova-settings-tool-form')
                ->assertSee('Hello Field');

            $browser->blank();
        });
    }
}
