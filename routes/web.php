<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
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

Route::get('/', [HomeController::class, 'getHomePage'])->name('home');
Route::get('/phim-{name}', [MovieController::class, 'getMovieByName'])->name('detail_name');
Route::get('/phim-{name}/tap-{episode}', [MovieController::class, 'getMovieByNameEposode'])->name('detail_name_episode');
Route::post('/episode-ajax', [MovieController::class, 'getEpisodeAjax'])->name('episode-ajax');
Route::post('/home-ajax', [HomeController::class, 'getHomeAjax'])->name('home-ajax');
Route::get('/search/{value}', [HomeController::class, 'searchMovieAdvanced'])->name('search_advanced');
Route::get('/search_ad_more/{value}', [HomeController::class, 'searchMovieAdvancedMore'])->name('search_advanced_more');