<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you caGETn register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/members/get-inner-html', [MemberController::class, 'showTable'])->name('members.getInnerHTML');
    Route::get('/members/list', [MemberController::class, 'list'])->name('members.list');
    Route::resource('/members', MemberController::class);
});

//Route::get('/members/list', [MemberController::class, 'list'])->name('members.list');
//Route::resource('/members', MemberController::class);
