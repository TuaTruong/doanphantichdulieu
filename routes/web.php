<?php

use App\Http\Controllers\ProxyController;
use App\Http\Controllers\XoiLacController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
Route::get("/xoilac",[XoiLacController::class,'index']);
Route::get("xoilac_analyst",[XoiLacController::class,'analyst']);
Route::get("/fetch-all",[XoiLacController::class,'fetchAll']);
Route::get("/add-proxy",[ProxyController::class,'addProxy']);
Route::post("/update-proxy",[ProxyController::class,'updateProxy']);
Route::post("/save-data",[XoiLacController::class,'save_data']);
Route::get('/match-chart', [XoiLacController::class,'matchChart']);
Route::post("/get-match-statistic",[XoiLacController::class,'getMatchStatistic']);
Route::get("/test-match-statistic",[XoiLacController::class,'testMatchStatistic']);
Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
