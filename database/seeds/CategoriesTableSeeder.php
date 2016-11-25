<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories = array(
    		1   => array('Ngân hàng/ Tín dụng'  ,'Banking / Credit'),
            2   => array('Tiền mặt/ Vay'        ,'Cash / borrowings'),
            3   => array('Đầu tư'               ,'Invest'),
            4   => array('Bảo hiểm'             ,'Insurrance'),
            5   => array('Nhân lực'             ,'Human'),
            6   => array('Điện/Gas'             ,'Electricity / Gas'),
            7   => array('Thời trang'           ,'Fashion'   ),
            8   => array('Thể thao'             ,'Sport'),
            9   => array('Thực phẩm'            ,'Food'),
            10  => array('Du lịch'              ,'Travel'),
            11  => array('Khỏe / đẹp'           ,'Health and beauty'),
            12  => array('Nội thất / tiện nghi' ,'Furniture / convenience'),
            13  => array('Game'                 ,'Game'),
            14  => array('Giải trí'             ,'Entertainment'),
            15  => array('Cộng đồng'            ,'Public'),
            16  => array('Ô tô / Xe máy'        ,'Auto and Moto'),
            17  => array('Shops'                ,'Shops'),
            18  => array('Bất động sản'         ,'Real estate'),
            19  => array('Giáo dục'             ,'Education'),
            20  => array('Sách '                ,'Book'),
            21  => array('Dịch vụ Internet'     ,'Internet service'),
            999 => array('Others'               ,'Others' ) 
    	);
    	foreach ($categories as $key => $value) {
	        DB::table('categories')->insert([
                'id' => $key,
	            'category_vn' => $value[0],
	        	'category_en' => $value[1],
	        	'order' => rand(0, 1),
                'status' => 1,
	        	'created_at' => date('Y-m-d'),
	        	'updated_at' => date('Y-m-d'),
	        ]);
        }
    }
}
