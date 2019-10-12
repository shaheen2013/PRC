<?php

use App\Models\CommunityStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunityStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CommunityStatus::create(['id' => '1', 'label' => 'Not Reviewed', 'external_label' => 'Not Reviewed']);
        CommunityStatus::create(['id' => '3', 'label' => 'Approved', 'external_label' => 'Approved']);
        CommunityStatus::create(['id' => '4', 'label' => 'Update Saved', 'external_label' => 'Pending Approval']);
        CommunityStatus::create(['id' => '5', 'label' => 'Pending Approval', 'external_label' => 'Pending Approval']);
        CommunityStatus::create(['id' => '6', 'label' => 'No Ordinance', 'external_label' => 'No Ordinance']);
        CommunityStatus::create(['id' => '7', 'label' => 'Update Requested', 'external_label' => 'Pending Approval']);
    }
}
