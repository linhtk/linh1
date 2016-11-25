<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Config connection to civi
    |--------------------------------------------------------------------------
    | Api key to encrypt
    | IP + URL change by environment
    |
    */

    'api_key' => env('APP_KEY_API'),
    'ip_civi' => env('IP_CIVI'),
    'url_civi' => env('URL_CIVI'),

    /*
    |--------------------------------------------------------------------------
    | Code handle to check
    |--------------------------------------------------------------------------
    | Error code return 500
    | Success code return 200
    */

    'error_code' => 500,
    'success_code' => 200,


    /*
    |--------------------------------------------------------------------------
    | Request type
    |--------------------------------------------------------------------------
    | 0 : request on create api
    | 1 : request on update api
    */

    'request_create' => 0,
    'request_update' => 1,
    'api_point_flag' => 'point',
    'api_create_flag' => 'create',
    'api_update_flag' => 'update',
    'api_commit_flag' => 'commit',
    'api_test_flag' => 'test',


    /*
    |--------------------------------------------------------------------------
    | API list connect to civi
    |--------------------------------------------------------------------------
    |
    */

    'api_list' => [
        'point' => env('URL_CIVI')."/pub-point",
        'create' => env('URL_CIVI')."/pub-register",
        'update' => env('URL_CIVI')."/pub-register",
        'commit' => env('URL_CIVI')."/pub-commit",
    ],

    /*
    |--------------------------------------------------------------------------
    | Logger message define flag
    |--------------------------------------------------------------------------
    |
    */

    'request_flag' => 'request',
    'response_flag' => 'response',
    'error_flag' => 'error',
    'exception_flag' => 'exception',

    /*
    |--------------------------------------------------------------------------
    | Log description on log file
    |--------------------------------------------------------------------------
    |
    */

    'cbm_error_msg' => 'Has error when call api',
    'cbm_format_pubid_msg' => 'Invalid format pubid data',
    'cbm_format_trans_token_msg' => 'Invalid format transaction token key',
    'cbm_format_point_msg' => 'Invalid format point data',
    'cbm_format_ip_msg' => 'Invalid ip connect civi',
];
