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

Route::get('/', function () {
    return view('pages.home');
});
Route::get('/projects', function () {
    return view('pages.projects');
});
Route::get('/blog', function () {
    return view('pages.blog');
});
Route::get('/project/angular', function () {
    return view('project.angular',['title'=>'Angular']);
});
