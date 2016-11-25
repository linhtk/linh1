<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', 'ToppageController@index');
Route::get('/category/{id}', 'ToppageController@category');
//Route::get('/detail/{id}', 'ToppageController@detail');
Route::post('/search', 'ToppageController@search');
Route::get('/search', 'ToppageController@search');
Route::get('/detail',
    [
        'as' => 'toppage.detail',
        'uses' =>'ToppageController@detail'
    ]);
Route::get('/get_civi',
    [
        'as' => 'toppage.civi',
        'uses' =>'ToppageController@getCivi'
    ]);

Route::group(['prefix' => 'account'], function()
{
    Route::get('/register', 'AccountController@getRegister');
    Route::post('/register', 'AccountController@postRegister');

    Route::get('/confirm', 'AccountController@getConfirm');
    Route::post('/confirm', 'AccountController@postConfirm');

    Route::get('/active', 'AccountController@getActive');
    Route::get('/verify',
        [
            'as' => 'account.verify',
            'uses' =>'AccountController@getVerify'
        ]);
    Route::get('/finish', 'AccountController@getFinish');

    Route::get('/edit_account', 'AccountController@getEditAccount');
    Route::post('/edit_account', 'AccountController@postEditAccount');
    Route::get('/confirm_account', 'AccountController@getConfirmAccount');
    Route::post('/confirm_account', 'AccountController@postConfirmAccount');
    Route::get('/finish_account', 'AccountController@getFinishAccount');

    Route::get('/edit_bank', 'AccountController@getEditBank');
    Route::post('/edit_bank', 'AccountController@postEditBank');
    Route::get('/confirm_bank', 'AccountController@getConfirmBank');
    Route::post('/confirm_bank', 'AccountController@postConfirmBank');
    Route::get('/finish_bank', 'AccountController@getFinishBank');

    Route::get('/mypage', 'AccountController@getMyPage');

    Route::get('/pwd_email', 'AccountController@getPasswdEmail');
    Route::post('/pwd_email', 'AccountController@postPasswdEmail');
    Route::get('/pwd_active', 'AccountController@getPasswdActive');

    Route::get('/pwd_verify',
        [
            'as' => 'account.pwd_verify',
            'uses' =>'AccountController@getPwdVerify'
        ]);
    Route::post('/pwd_verify', 'AccountController@postPwdVerify');
    Route::get('/pwd_finish', 'AccountController@getPwdFinish');

    Route::get('/login',
        [
            'as' => 'account.get_login',
            'uses' =>'AccountController@getLogin'
        ]);
    Route::post('/login',
        [
            'as' => 'account.post_login',
            'uses' =>'AccountController@postLogin'
        ]);

    Route::get('/logout', 'AccountController@getLogout');

    Route::get('/payment', 'AccountController@getPaymentAccount');
    Route::post('/payment', 'AccountController@getPaymentAccount');
    Route::get('/point', 'AccountController@getPointAccount');
    Route::post('/point', 'AccountController@getPointAccount');
});

Route::group(['prefix' => 'error'], function()
{
    Route::get('/error', 'ErrorController@getError');

});

Route::get('maintenance', 'ErrorController@getMaintain');

Route::group(['prefix' => 'admin'], function () {
    //Login Routes...
    Route::get('/login','Admin\AdminController@showLoginForm');
    Route::post('/login','Admin\AdminController@postlogin');
    Route::get('/logout','Admin\AdminController@getLogout');

    Route::get('/', 'Admin\AdminController@index');
    Route::get('/payment', 'Admin\AdminController@getPaymemt');
    Route::post('/payment', 'Admin\AdminController@getPaymemt');
    Route::post('/save_all_payment', 'Admin\AdminController@saveAllPayment');
});

Route::get('/faq', 'ToppageController@faq');

Route::get('/contact', 'ContactController@index');
Route::post('/contact/preview', 'ContactController@preview');
Route::post('/contact/submit', 'ContactController@submit');
Route::get('/contact/finish', 'ContactController@finish');
Route::get('/refreshrecaptcha', 'ContactController@refreshCaptcha');