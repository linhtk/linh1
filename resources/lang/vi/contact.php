<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'inquiry' => 'Liên hệ',
    'err_contact'=>'Không thể hoàn thành gửi contact.',
    'input_form' => 'Nhập câu hỏi',
    'preview' => 'Xem trước',
    'confirm' => 'Xác nhận',
    'back' => 'Quay lại',
    'back_to_top' => 'Quay về trang chủ',
    'submit' => 'Gửi',
    'finish' => 'Hoàn thành',
    'finish_notif' => 'Chúng tôi đã nhận được câu hỏi và đã gửi lại một email xác nhận vào hòm thư của bạn.<br>Chúng tôi sẽ trả lời bạn trong vòng 3 ngày làm việc.',
    'name' => 'Họ tên',
    'email' => 'Email',
    'inquiry_type' => 'Vấn đề',
    'contents' => 'Nội dung',
    'captcha' => 'Mã xác minh',
    'placeholder_name' => 'Nhập họ tên',
    'placeholder_email' => 'Nhập email',
    'placeholder_contents' => 'Nhập câu hỏi',

    'send_mail_user_title' => Config::get('app.domain').' - Hỗ trợ dịch vụ',
    'send_mail_admin_title' => Config::get('app.domain').' - Inquiry email alert',
    'send_mail_user_content_1' => 'Xin chào ',
    'send_mail_user_content_2' => ",<br><br>
                                    Cảm ơn bạn đã liên hệ với chúng tôi.<br>
                                    Chúng tôi đã nhận được câu hỏi của bạn và sẽ trả lời bạn trong vòng 3 ngày làm việc.<br>
                                    Vui lòng chờ liên hệ từ chúng tôi. <br><br>
                                    Dưới đây là câu hỏi của bạn:<br>
                                    ----------------------------------------------------------------------------------------------<br>
                                    Vấn đề : ",
    'send_mail_user_content_3' => '<br><br>',
    'send_mail_user_content_4' => "<br>
                                    ----------------------------------------------------------------------------------------------<br><br>
                                    Xin trân trọng cảm ơn,<br><br>
                                    Ghi chú: Địa chỉ email này chỉ dùng để gửi thư. Vui lòng không trả lời lại email này.",
    'send_mail_admin_content_1' => 'Dear CBM service representatives,<br>
                                    We accept a inquiry from user.<br><br>
                                    Please check follows;<br><br>
                                    date : ',
    'send_mail_admin_content_2' => '<br>name : ',
    'send_mail_admin_content_3' => '<br>email : ',
    'send_mail_admin_content_4' => '<br>userid : ',
    'send_mail_admin_content_5' => '<br>inquiry type : ',
    'send_mail_admin_content_6' => '<br>login : ',
    'send_mail_admin_content_7' => '<br>IP : ',
    'send_mail_admin_content_8' => '<br>useragent : ',
    'send_mail_admin_content_9' => '<br>----------------------------------------------------------------------------------------------<br>',
    'send_mail_admin_content_10' => "<br><br>
                                    ----------------------------------------------------------------------------------------------<br><br>
                                    Regards,<br><br>
                                    Note: this email address is for sending email only. we can't reply if you send this sender email address."
];
