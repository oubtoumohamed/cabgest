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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	Route::get('/admin/', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin');
	Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
});

include 'larabase.php';

include 'user.php';
include 'groupe.php';

include 'leave.php';
include 'motif.php';
include 'rendezvous.php';
include 'patient.php';

include 'analyse.php';
include 'caisse.php';
include 'dossier.php';
include 'medicament.php';