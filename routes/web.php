<?php

use System\Router\Web\Route;


// home routes
Route::get('', 'HomeController@index', 'index');
Route::get('create', 'HomeController@create', 'create');
Route::post('store', 'HomeController@store', 'store');
Route::get('edit/{id}', 'HomeController@edit', 'edit');
Route::put('/update/{id}', 'HomeController@update', 'update');
Route::delete('/delete/{id}', 'HomeController@destroy', 'delete');

//admin routes 
Route::get('/admin', 'Admin\AdminController@index',     'admin.index');


//category routes
Route::get('/admin/category', 'Admin\CategoryController@index',     'admin.category.index');
Route::get('/admin/category/create', 'Admin\CategoryController@create',     'admin.category.create');
Route::post('/admin/category/store', 'Admin\CategoryController@store',     'admin.category.store');
Route::get('/admin/category/edit/{id}', 'Admin\CategoryController@edit',     'admin.category.edit');
Route::put('/admin/category/update/{id}', 'Admin\CategoryController@update',     'admin.category.update');
Route::delete('/admin/category/destroy/{id}', 'Admin\CategoryController@destroy',     'admin.category.destroy');



//post routes
Route::get('/admin/post', 'Admin\PostController@index','admin.post.index');
Route::get('/admin/post/create', 'Admin\PostController@create','admin.post.create');
Route::post('/admin/post/store', 'Admin\PostController@store','admin.post.store');
Route::get('/admin/post/edit/{id}', 'Admin\PostController@edit','admin.post.edit');
Route::put('/admin/post/update/{id}', 'Admin\PostController@update','admin.post.update');
Route::delete('/admin/post/destroy/{id}', 'Admin\PostController@destroy','admin.post.destroy');





