<?php

use Illuminate\Database\Seeder;
use App\Helpers\Utils;
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salt = config('const.const_salt');
        $passwd = '12345678';
        $encode_passwd = Utils::encrypt_password($passwd,$salt);
        DB::table('admins')->insert([
            'role_id' => 1,
            'firstname' => 'admin',
            'lastname' => 'system',
            'email' => 'admin@gmail.com',
            'password' => $encode_passwd,
            'status' => 1
        ]);
    }
}
