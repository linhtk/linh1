<?php
return [

    'const_salt' => env('CONST_SALT', 'WZGbaUcmdBwfwZbfYzbzuNSDvWhFSgBO'),
    'const_key_token' => env('CONST_KEY_TOKEN', '968e03fb7fbc5c36d3be9a9b635ecd5109ae4abafdc4e39343807e0eeaa4d3e6'),
    'const_pre_memcached' => env('CONST_PRE_MEMCACHED', 'cbm_sign_up'),
    'const_expire_memcached' => env('CONST_EXPIRE_MEMCACHED', 1440),
    'const_pre_memcached_forget_pwd' => env('CONST_PRE_MEMCACHED_FORGET_PWD', 'cbm_forget_pwd'),
	'time_expire_memcached' => env('TIME_EXPIRE_MEMCACHED', 400),
    'number_page_paginate' => env('NUMBER_PAGE_PAGINATE', 9),
    'number_page_spotLights' => env('NUMBER_PAGE_SPOTLIGHTS', 4),
    'number_page_recommends' => env('NUMBER_PAGE_RECOMMENDS', 24),
    'type_spotLights' => env('TYPE_SPOTLIGHTS', 0),
    'type_recommends' => env('TYPE_RECOMMENDS', 1),
    'key_categorys' => env('KEY_CATEGORYS', 'key_categorys'),
    'key_carousels' => env('KEY_CAROUSELS', 'key_carousels'),
    'key_spotLights' => env('KEY_SOPTLIGHTS', 'key_spotLights'),
    'key_recommends' => env('KEY_RECOMMENDS', 'key_recommends'),
    'pre_detail_campaign_thank' => env('CONST_PREFIX_DETAIL_CAMPAIGN_THANK', 'detail_campaign_thank'),
    'pre_list_category' => env('PRE_LIST_CATEGORY', 'pre_list_category'),
    'cost_recommended' => env('CONST_RECOMMENDED', 'config_recommended'),
    'cost_media_id' => env('MEDIA_ID', '16'),
    'cost_pub_id' => env('PUB_ID', '5'),
    'const_salt_user_id' => env('CONST_SALT_USER_ID', 'KaymNbgxkwEUdsaWDePBIvovphyzhSEt'),
    'backend_arr_permission' => array(
        1=> array('admin/payment'),
        2=>array()
    ),
    'backend_number_page_payment' => env('BACKEND_NUMBER_PAGE_PAYMENT', 100),
    'frontend_number_page_payment' => env('FRONTEND_NUMBER_PAGE_PAYMENT', 3),
    'backend_money_limit' => env('BACKEND_MONEY_LIMIT', 200000),
	'point_batch_report' => 200000,
    'month_start_payment' => env('MONTH_START_PAYMENT', '11/2016'),
    'date_start_payment' => env('DATE_START_PAYMENT', '2016-11-01'),
    'backend_login_number_limit' => env('BACKEND_LOGIN_NUMBER_LIMIT', 10),
    'backend_login_time_lock' => env('BACKEND_LOGIN_TIME_LOCK', 300),

    'civi_api_url' => env('CIVI_API_URL', 'http://210.211.102.93/'),
    'civi_api_type' => array(
        'cpc'=> env('CIVI_CPC_API', 'cpc'),
    ),
    'frontend_point_log_num_date' => env('FRONTEND_POINT_LOG_NUM_DATE', 10),
];
