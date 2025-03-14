<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguagesSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(RolePermissionsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(WidgetsAreaSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(ToolSeeder::class);
        $this->call(PropertiesSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(PlansSeeder::class);
        $this->call(FaqsSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(ToolDriversSeeder::class);
        $this->call(HomepageSeeder::class);
        $this->call(CountriesTableSeeder::class);

        if (file_exists(base_path('database/seeders/Update11Seeder.php'))) {
            $this->call(Update11Seeder::class);
        }

        if (file_exists(base_path('database/seeders/UpdateSeederV12.php'))) {
            $this->call(UpdateSeederV12::class);
        }

        if (file_exists(base_path('database/seeders/UpdateToolSeeder.php'))) {
            $this->call(UpdateToolSeeder::class);
        }

        if (file_exists(base_path('database/seeders/UpdateToolSeeder210.php'))) {
            $this->call(UpdateToolSeeder210::class);
        }

        if (file_exists(base_path('database/seeders/UpdateToolSeeder220.php'))) {
            $this->call(UpdateToolSeeder220::class);
        }

        if (file_exists(base_path('database/seeders/NewToolsSeeder.php'))) {
            $this->call(NewToolsSeeder::class);
        }
    }
}
