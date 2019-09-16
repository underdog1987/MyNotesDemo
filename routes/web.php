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
    return view('welcome');
});

// Services witout auth
Route::get('/note/{id}/{format}', 'NotesController@getNote');
Route::get('/notes/{format}', 'NotesController@getNotes');

Auth::routes();
// Services with Auth //
Route::get('/home', 'HomeController@index'); // Dashboard
Route::get('/secret-area', 'HomeController@someAdminStuff'); // Test Access 4 Admin only
Route::get('/user-notes', 'HomeController@userNotes'); // JSON with user notes
Route::post('note/add', 'HomeController@createNote'); // Create new note
Route::delete('/note/{id}', 'HomeController@deleteNote'); // Delete a note
Route::put('/note/{id}', 'HomeController@updateNote'); // Update a note


