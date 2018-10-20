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

//サインアップまたはログイン認証が行われていなければ Welcomeのviewを表示し,　
//サインアップまたはログイン認証が正常ならば、一覧画面を表示させるためにuser.show を表示します。
Route::get('/', 'MicropostsController@index');

//サインアップ
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

//ログイン認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

//ユーザ一覧(index)・詳細(show)、投稿(store)・削除(destroy)
Route::group(['middleware' => 'auth'], function (){
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    Route::group(['prefix' => 'users/{id}'],function (){
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        
        Route::post('favorite', 'FavoriteController@store')->name('user.favorite');
        Route::delete('unfavorite', 'FavoriteController@destroy')->name('user.unfavorite');
        Route::get('favoriting', 'FavoriteController@favoriting')->name('user.favoriting');
    });

    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
});