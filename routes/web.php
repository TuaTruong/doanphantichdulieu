<?php

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

Route::get('/', function (){
    return view('welcome');
})->name('root');
//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
Route::get("/xoilac",[XoiLacController::class,'index']);
Route::get("/xoilac_analyst",[XoiLacController::class,'analyst']);
Route::get("/fetch-all",[XoiLacController::class,'fetchAll']);
Route::post("/save-data",[XoiLacController::class,'save_data']);
Route::get('/match-chart', [XoiLacController::class,'matchChart']);
Route::post("/get-match-statistic",[XoiLacController::class,'getMatchStatistic']);
Route::get("/test-match-statistic",[XoiLacController::class,'testMatchStatistic']);
Route::get("/test",[XoiLacController::class,'test_analyst']);
Route::get("/test-save-data",[XoiLacController::class,'test_save_data']);
Route::get("/all-matches",[XoiLacController::class,'allMatches']);
Route::get("/match-statistic/{matchId}",[XoiLacController::class,'matchStatistic']);
Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
