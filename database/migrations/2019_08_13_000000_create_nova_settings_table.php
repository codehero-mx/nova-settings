<?php

use CodeHeroMX\SettingsTool\SettingsTool;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(SettingsTool::getSettingsTableName(), function (Blueprint $table) {
            $table->string('key')
                ->unique()
                ->primary();
            $table->text('value')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(SettingsTool::getSettingsTableName());
    }
};
