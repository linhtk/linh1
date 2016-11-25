<?php

use Illuminate\Database\Seeder;

class CarouselsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$carousels = array(
    		array('/img/banner.png')
    	);
    	for($i=0;$i<4;$i++){
	        DB::table('carousels')->insert([
	            'title' => 'carousels'.$i,
	        	'banner_path' => $carousels[0][0],
	        	'banner_link' => '',
	        	'order' => rand(0, 1),
	        	'status' => rand(0, 1),
	        	'created_at' => date('Y-m-d'),
	        	'updated_at' => date('Y-m-d')
	        ]);
        }
    }
}
