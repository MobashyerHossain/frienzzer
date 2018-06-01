<?php
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

Route::get('/', 'PagesController@index')->name('index');

Route::get('/newusercreated', 'PagesController@index')->name('index');

Route::get('/profile/{id}/{last_name}', 'PagesController@profile')->name('profile');

Route::get('/about/{id}/{last_name}', 'PagesController@profile')->name('profile');

Route::get('/friends/{id}/{last_name}', 'PagesController@profile')->name('profile');

Route::get('/photos/{id}/{last_name}', 'PagesController@profile')->name('profile');

Route::get('/messanger/{id_1}/{id_2}', 'PagesController@messanger')->name('messanger');

Route::get('/friend/requests', 'PagesController@request')->name('request');

Route::resource('posts', 'PostsController');

Route::resource('comments', 'CommentsController');

Route::resource('media', 'MediaController');

Route::resource('likes', 'LikesController');

Route::resource('messages', 'MessagesController');

Route::resource('friends', 'FriendsController');

Route::resource('tags', 'TagsController');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/posts', 'DashboardController@index')->name('dashboard');
