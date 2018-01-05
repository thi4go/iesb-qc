<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/dashboard/reportar','Dashboard\ContactController@reportError');
Route::post('/dashboard/recover-password','Dashboard\AuthController@sendRecoveryMail');
Route::post('/dashboard/contact-mail','Dashboard\ContactController@postContact');
Route::post('/dashboard/ask-lesson','Dashboard\ContactController@askLesson');

