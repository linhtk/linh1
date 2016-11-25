<?php

use Illuminate\Database\Seeder;

class CampaignPromotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //spotlight
        for($i=0;$i<4;$i++){
            $id = rand(1, 1000);
	        DB::table('campaign_promotes')->insert([
	        	'campaign_id' => $id, 
                'id_thanks' => $id, 
	        	'type' => 0, 
	        	'order' => $i 
         	]);
        }
        //recommended
        for($i=0;$i<24;$i++){
            $id = rand(1, 1000);
            DB::table('campaign_promotes')->insert([
                'campaign_id' => $id, 
                'id_thanks' => $id, 
                'type' => 1, 
                'order' => $i 
            ]);
        }
    }
}
