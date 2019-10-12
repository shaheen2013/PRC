<?php

use Illuminate\Database\Seeder;
use App\Models\OrganizationType;

class OrganizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrganizationType::create(['id' => '18', 'label' => 'PRC', 'abbreviation' => 'PRC', 'order' => '1']);
        OrganizationType::create(['id' => '20', 'label' => 'Government', 'abbreviation' => 'GOV', 'order' => '2']);
        OrganizationType::create(['id' => '21', 'label' => 'Responsible Party', 'abbreviation' => 'RP', 'order' => '3']);
        OrganizationType::create(['id' => '22', 'label' => 'Relationship Manager', 'abbreviation' => 'RM', 'order' => '4']);
    }
}
