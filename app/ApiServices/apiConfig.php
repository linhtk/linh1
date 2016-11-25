<?php
define('CBM_ERROR_CODE', 500);
define('CBM_SUCCEED_CODE', 200);
define('IP_CIVI', '192.168.1.1');

define('REAL_HOST', 'http://cbm.local');
define('REAL_IP','127.0.0.1');

define('REQUEST_TYPE_CREATE',0);
define('REQUEST_TYPE_UPDATE',1);

define('INVALID_FLAG', 0);
define('VALID_FLAG', 1);

define('POINT_API','point');
define('CREATE_API', 'create');
define('UPDATE_API', 'update');
define('COMMIT_API' ,'commit');
define('TEST_API' ,'test');

// get url civi api from request key
define('LIST_API', serialize([
    POINT_API => REAL_HOST."/api/v1/point",
    CREATE_API => REAL_HOST."/api/v1/create",
    UPDATE_API => REAL_HOST."/api/v1/update",
    COMMIT_API => REAL_HOST."/api/v1/commit",
    TEST_API => REAL_HOST."/api/v1/testConnect"
]));

define('REQUEST_FLAG', 'request');
define('RESPONSE_FLAG', 'response');
define('ERROR_FLAG', 'error');
define('EXCEPTION_FLAG', 'exception');

define('CBM_ERROR_MSG', 'Has error when call api');
define('CBM_FORMAT_PUBID_MSG', 'Invalid format pubid data');
define('CBM_FORMAT_TRANS_TOKEN_MSG', 'Invalid format transaction token key');
define('CBM_FORMAT_POINT_MSG', 'Invalid format point data');
