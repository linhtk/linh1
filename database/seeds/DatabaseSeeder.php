<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriesTableSeeder::class);
        $this->call(CarouselsTableSeeder::class);
        $this->call(CampaignsTableSeeder::class);
        $this->call(CampaignPromotesTableSeeder::class);
        //$this->call(ThanksTableSeeder::class);
    }
}
