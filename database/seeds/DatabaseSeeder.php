<?php

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
        $this->call([
            SongSeeder::class,
            AuthorSeeder::class,
            UserSeeder::class,
            UserRolesPermissionsSeeder::class
        ]);
    }
}
