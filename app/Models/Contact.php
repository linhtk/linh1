<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
	const INQUIRY_TYPE = array(
        1 => 'Dịch vụ',
        2 => 'Thanh toán',
        3 => 'Khác'
    );
    const CONTACT_TIMES_MAX = 3;
    protected   $table = 'contacts';
    protected $fillable = ['name', 'email', 'user_id', 'inquiry_type', 'contents', 'ip', 'user_agent', 'del_flag'];
}
