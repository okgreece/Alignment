<?php

use App\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = Settings::all()->count();
        $this->command->info('Found '.$count.' settings.');
        if ($count === 0) {
            $this->command->info('Settings table empty. Running seeder...');
            $settings = new Settings();
            $settings->name = 'DEFAULT';
            $settings->user_id = 1;
            $settings->public = true;
            $settings->valid = true;
            $file = '/app/projects/default_config.xml';
            $filename = storage_path().$file;
            $tmpFilePath = sys_get_temp_dir().'/default_config.xml';
            copy($filename, $tmpFilePath);
            $settings->resource = $tmpFilePath;
            $settings->save();
        }
    }
}
