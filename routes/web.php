<?php

Auth::routes();

Route::post('/otestuj', 'TestController@store');

Route::get('/myPosts/{any}','AuthorizedController@index')->where('any', '.*');
Route::get('/myPosts','AuthorizedController@index');
Route::get('/','HomeController@index');
Route::get('/{any}','HomeController@index')->where('any', '.*');
