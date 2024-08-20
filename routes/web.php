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

Route::get('', function () {
    return redirect('/comments');
});

Route::get('login', function () {
    if (auth()->user()) {
        return redirect('/');
    }
    return view('auth.login');
})->name('login');
Route::post('login', [
    'as'     => 'login',
    'uses'   => 'App\Http\Controllers\LoginController@login',
]);
Route::post('logout', [
    'as'     => 'logout',
    'uses'   => 'App\Http\Controllers\LoginController@logout',
]);

Route::group([
    'prefix' => 'comments',
    'middleware' => 'admin',
    'namespace' => 'App\Http\Controllers'
], function () {
    Route::get('', [
        'as'     => 'comments.list',
        'uses'   => 'CommentController@getComments',
    ]);
    Route::post('', [
        'as'     => 'comments.create',
        'uses'   => 'CommentController@create',
    ]);
    Route::put('/{id}', [
        'as'     => 'comments.update',
        'uses'   => 'CommentController@update',
    ]); // OK
    Route::delete('/{id}', [
        'as'     => 'comments.delete',
        'uses'   => 'CommentController@delete',
    ]); // OK
});

Route::any('{query}',
    function() { return redirect('/'); })
    ->where('query', '.*');
