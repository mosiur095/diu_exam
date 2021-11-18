<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/{any}', function () {
//     return view('welcome');
// })->where('any','.*');

// Route::get('/select_class/{1}','QuizController@fetch_class');
Route::get('/','QuizController@index');
Route::get('/report','QuizController@report');
Route::get('/fetch_class','QuizController@fetch_class');
Route::get('/fetch_subject','QuizController@fetch_subject');
Route::get('/fetch_quiz','QuizController@fetch_quiz');
Route::post('/store','QuizController@store');
Route::get('/edititem','QuizController@edit_item');
Route::get('/delete_item','QuizController@delete_item');
Route::post('/update','QuizController@update');
Route::get('/image',function () {
	return view('pages/image');
});
Route::post('/image_upload','QuizController@image_upload');
