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

Route::middleware('auth:api')->group(function() {
    // Posts
    Route::post('/posts', 'PostsController@store');
    Route::get('/posts', 'PostsController@index');

    Route::patch('/posts/{post}', 'PostsController@update');

    Route::get('/posts/create', 'PostsController@create');
    Route::get('/posts/{post}/edit', 'PostsController@edit');

    Route::get('/posts/{post}', 'PostsController@show');
    Route::get('/posts/comments/{post}', 'PostsController@postComments');
    Route::delete('/posts/delete/{post}', 'PostsController@delete');          // ------

    // Comments
    Route::post('/comments', 'CommentsController@store');
    Route::patch('comments/{comment}' , 'CommentsController@update');
    Route::delete('/comments/{comment}', 'CommentsController@delete');

    // Category
    Route::post('/categories', 'CategoriesController@store');
    Route::patch('categories/{category}' , 'CategoriesController@update');
    Route::delete('/categories/{category}', 'CategoriesController@delete');


});

//All posts
Route::get('/allPosts/category/{categoryName}', 'AllPostsController@postsByCategory');
Route::get('/allPosts', 'AllPostsController@index');
Route::get('/categories', 'CategoriesController@index');
Route::get('/allPosts/{post}', 'AllPostsController@show');
