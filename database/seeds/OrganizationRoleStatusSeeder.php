<?php

use Illuminate\Database\Seeder;
use App\Models\OrganizationRoleStatus;

class OrganizationRoleStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrganizationRoleStatus::create(['label' => 'Pending']);
        OrganizationRoleStatus::create(['label' => 'Confirmed']);
    }
}
