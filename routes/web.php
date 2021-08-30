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

Route::get('/', function () {
    return redirect('/login'); // view('welcome');
});

Route::get('/consulta', [App\Http\Controllers\ConsultId::class, 'index'])->name('consulta');
Route::post('/consultasuser', [App\Http\Controllers\ConsultId::class, 'consuluser'])->name('consultasuser');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Users
    Route::get('/user', [App\Http\Controllers\admin\UserController::class, 'index']);
    Route::get('/user/create', [App\Http\Controllers\Admin\UserController::class, 'create']);//form create
    Route::post('/user', [App\Http\Controllers\admin\UserController::class, 'store']);// envio form
    Route::get('/user/{user}/edit', [App\Http\Controllers\admin\UserController::class, 'edit']); //form edit
    Route::put('/user/{user}', [App\Http\Controllers\admin\UserController::class, 'update']);//envio form
    Route::get('/user/avatar/{filename?}', [App\Http\Controllers\admin\UserController::class, 'getImage'])->name('user.avatar');
    Route::get('/user/avatardoc/{filename?}', [App\Http\Controllers\admin\UserController::class, 'getImageDoc'])->name('user.avatardoc');


    //Users perfil updatephoto
    Route::get('/user/indexperfil', [App\Http\Controllers\admin\UserController::class, 'indexperfil']);
    //Route::get('/user/{user}/editperfil', [App\Http\Controllers\admin\UserController::class, 'editperfil']);//form edit
    //Route::post('/user/{user}', [App\Http\Controllers\admin\UserController::class, 'updatephoto']);// envio form


    //Membresias
    Route::get('/membresias', [App\Http\Controllers\MembresiaController::class, 'index'])->name('membresias');
    Route::get('/membresiasuser', [App\Http\Controllers\MembresiaController::class, 'indexuser'])->name('membresiasuser');;
    Route::get('/membresias/create', [App\Http\Controllers\MembresiaController::class, 'create']);//form create
    Route::post('/membresias', [App\Http\Controllers\MembresiaController::class, 'store']);// envio form
    Route::get('/membresias/{membresias}/edit', [App\Http\Controllers\MembresiaController::class, 'edit']); //form edit
    Route::put('/membresias/{membresias}', [App\Http\Controllers\MembresiaController::class, 'update']);//envio form
