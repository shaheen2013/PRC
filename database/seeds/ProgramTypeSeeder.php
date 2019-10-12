<?php

use App\Models\ProgramType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProgramType::create(['id' => '1', 'label' => 'Foreclosure']);
        ProgramType::create(['id' => '2', 'label' => 'Vacant']);
        ProgramType::create(['id' => '3', 'label' => 'Rental']);
    }
}
