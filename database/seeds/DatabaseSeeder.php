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
//          $this->call(UsersTableSeeder::class);
//          $this->call(StatesSeeder::class);
//          $this->call(CommunityStatusSeeder::class);
//          $this->call(InteractionTypesSeeder::class);
          $this->call(SalesStatusSeeder::class);
          $this->call(OrganizationRoleStatusSeeder::class);
        $this->call(OrganizationTypeSeeder::class);
    }
}
