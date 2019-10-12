<?php

use App\Models\SalesStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalesStatus::create(['id' => '1', 'label' => 'No Activity', 'order' => '1']);
        SalesStatus::create(['id' => '5', 'label' => 'Partner', 'order' => '8']);
        SalesStatus::create(['id' => '6', 'label' => 'Engaged', 'order' => '7']);
        SalesStatus::create(['id' => '7', 'label' => 'Target 1', 'order' => '4']);
        SalesStatus::create(['id' => '10', 'label' => 'No Interest', 'order' => '2']);
        SalesStatus::create(['id' => '11', 'label' => 'Target 2', 'order' => '5']);
        SalesStatus::create(['id' => '12', 'label' => 'Target 3', 'order' => '6']);
        SalesStatus::create(['id' => '13', 'label' => 'Prospect', 'order' => '3']);
    }
}
