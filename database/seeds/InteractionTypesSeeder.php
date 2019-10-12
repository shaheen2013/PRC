<?php

use App\Models\Interaction;
use App\Models\InteractionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InteractionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InteractionType::create(['label' => 'Note']);
        InteractionType::create(['label' => 'Email']);
        InteractionType::create(['label' => 'Phone Call']);
        InteractionType::create(['label' => 'HelpChamp Ticket']);
        InteractionType::create(['label' => 'Chat']);
        InteractionType::create(['label' => 'Meeting']);
    }
}
