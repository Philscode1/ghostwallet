<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PriceController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
})->name('welcome');

Route::get('/contact-us', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.us.index');
Route::post('/contact-us', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.us.store');

Route::view('/legal', 'legal.legal')->name('legal');
Route::view('/disclaimer', 'legal.disclaimer')->name('disclaimer');

// Routes Prices Cronjobs
Route::get('/prices-c1', [PriceController::class, 'c1'])->name('prices.c1');
Route::get('/prices-c2', [PriceController::class, 'c2'])->name('prices.c2');
Route::get('/prices-c3', [PriceController::class, 'c3'])->name('prices.c3');
Route::get('/prices-c4', [PriceController::class, 'c4'])->name('prices.c4');

Route::get('/prices-s1', [PriceController::class, 's1'])->name('prices.s1');
Route::get('/prices-s2', [PriceController::class, 's2'])->name('prices.s2');
Route::get('/prices-s3', [PriceController::class, 's3'])->name('prices.s3');
Route::get('/prices-s4', [PriceController::class, 's4'])->name('prices.s4');

Route::get('/prices-m1', [PriceController::class, 'm1'])->name('prices.m1');
Route::get('/prices-m2', [PriceController::class, 'm2'])->name('prices.m2');
Route::get('/prices-m3', [PriceController::class, 'm3'])->name('prices.m3');
Route::get('/prices-m4', [PriceController::class, 'm4'])->name('prices.m4');

Route::get('/prices-news', [PriceController::class, 'news'])->name('prices.news');


Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
    Route::get('/home/create',[HomeController::class,'create'])->name('home.create');
    Route::post('/home',[HomeController::class,'store'])->name('home.store');
    Route::get('/home/{asset}',[HomeController::class,'show'])->name('home.show');
    Route::get('/home/{asset}/edit',[HomeController::class,'edit'])->name('home.edit');
    Route::put('/home/{asset}',[HomeController::class,'update'])->name('home.update');
    Route::delete('/home/{asset}',[HomeController::class,'destroy'])->name('home.destroy');

    Route::get('/contact-us', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.us.index');
    Route::post('/contact-us', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.us.store');

    Route::get('/recommendation', [App\Http\Controllers\RecommendationController::class, 'index'])->name('recommendation.index');
    Route::post('/recommendation', [App\Http\Controllers\RecommendationController::class, 'store'])->name('recommendation.store');

});


