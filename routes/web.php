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


App::make('files')->link(storage_path('app/public'), public_path('storage'));

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/messages', 'MessagesController@index')->middleware('auth')->name('messages');

Route::post('/add/contact', 'MessagesController@add_contact')->middleware('auth')->name('addContact');

Route::post('/store/post', 'PostsController@store_post')->name('storePost');

Route::get('{postId}', 'PostsController@show_post')->middleware('auth')->name('showPost');

Route::get('posts/{userId}', 'PostsController@index')->middleware('auth')->name('showPosts');

Route::post("/edit/post","PostsController@edit_post")->name("editPost");

Route::post("update/post","PostsController@update_post")->name("updatePost");

Route::post("/destroy/post", "PostsController@destroy_post")->middleware("check_user")->name("destroyPost");

Route::post('destroy/comment', 'CommentsController@destroy_comment')->name('destroyComment');

Route::get('profile/{userId}', 'ProfileController@index')->middleware('auth')->name('showProfile');

Route::post('/store/user/data', 'ProfileController@store_user_data')->name('storeUserData');

Route::post('/store/comment', 'CommentsController@store_comment')->name('storeComment');

Route::post('/like', 'LikesController@store_like')->name('like');

Route::post('/follow', 'FollowersController@follow')->name('follow');

Route::post('/search', 'HomeController@search')->name('search');

Route::get('/search/{userName}', 'HomeController@show_results')->middleware('auth')->name('showResults');

Route::get('/messages/chat', 'MessagesController@chat')->middleware('auth')->name('chat');

Route::post('/messages/send', 'MessagesController@send')->middleware('auth')->name('send');

Route::get('/iframe/{postId}', 'PostsController@iframe_post')->name('iframePost');

Route::get('/info/{postId}', 'MessagesController@contact_info')->name('contactInfo');

