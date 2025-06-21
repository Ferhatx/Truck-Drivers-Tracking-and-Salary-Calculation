<?php

use App\Http\Controllers\HomeController;
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
/*
Route::get('/', function () {
    return view('welcome');
});
*/



//ADMİN PANEL
Route::get('/admin/login',[App\Http\Controllers\Admin\HomeController::class,'login'])->name('admin_login');
Route::post('/admin/logincheck',[App\Http\Controllers\Admin\HomeController::class,'logincheck'])->name('admin_logincheck');
Route::get('/logout',[App\Http\Controllers\Admin\HomeController::class,'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->group(function () {


    Route::get('/',[App\Http\Controllers\Admin\HomeController::class,'index'])->name('admin_home');

    //TIR ŞOFÖRÜ VERİLERİNİ EKLEDİĞİM YER
    Route::prefix('truckdriver')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TruckDriverController::class, 'index'])->name('admin_truckdriver');
        Route::get('create', [App\Http\Controllers\Admin\TruckDriverController::class, 'create'])->name('admin_truckdriver_add');
        Route::post('store', [App\Http\Controllers\Admin\TruckDriverController::class, 'store'])->name('admin_truckdriver_store');
        Route::post('shows', [App\Http\Controllers\Admin\TruckDriverController::class, 'shows'])->name('admin_truckdriver_shows');
        Route::get('edit/{id}', [App\Http\Controllers\Admin\TruckDriverController::class, 'edit'])->name('admin_truckdriver_edit');
        Route::get('update/{id}/{ad}/{soyad}/{tc_no}', [App\Http\Controllers\Admin\TruckDriverController::class, 'update'])->name('admin_truckdriver_update');
        Route::get('delete/{id}', [App\Http\Controllers\Admin\TruckDriverController::class, 'destroy'])->name('admin_truckdriver_delete');
        Route::get('show/{id}', [App\Http\Controllers\Admin\TruckDriverController::class, 'show'])->name('admin_truckdriver_show');
        Route::get('yazdir/{prnt_id}/{prnt_ay}/{prnt_yil}', [App\Http\Controllers\Admin\TruckDriverController::class, 'yazdir'])->name('admin_truckdriver_yazdir');
        Route::post('guncelle/{id}', [App\Http\Controllers\Admin\TruckDriverController::class, 'guncelle'])->name('admin_truckdriver_guncelle');
        Route::get('passive', [App\Http\Controllers\Admin\TruckDriverController::class, 'passive'])->name('admin_truckdriver_passive');
        Route::get('active/{id}/{ad}/{soyad}/{tc_no}/{dogum_tarihi}', [App\Http\Controllers\Admin\TruckDriverController::class, 'active'])->name('admin_truckdriver_active');

    });

//PUANTAJ İLE VERİLERİNİ EKLEDİĞİM YER
    Route::prefix('scorecard')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ScoreCardController::class, 'index'])->name('admin_scorecard');
        Route::get('create', [App\Http\Controllers\Admin\ScoreCardController::class, 'create'])->name('admin_scorecard_add');
        Route::post('store', [App\Http\Controllers\Admin\ScoreCardController::class, 'store'])->name('admin_scorecard_store');
        Route::get('edit/{id}', [App\Http\Controllers\Admin\ScoreCardController::class, 'edit'])->name('admin_scorecard_edit');
        Route::post('update/{id}', [App\Http\Controllers\Admin\ScoreCardController::class, 'update'])->name('admin_scorecard_update');
        Route::get('delete/{id}/{id2}', [App\Http\Controllers\Admin\ScoreCardController::class, 'destroy'])->name('admin_scorecard_delete');
        Route::get('show', [App\Http\Controllers\Admin\ScoreCardController::class, 'show'])->name('admin_scorecard_show');
    });



    Route::prefix('tanimlamalar')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TanimlamalarController::class, 'index'])->name('admin_tanimlamalar');
        Route::get('create', [App\Http\Controllers\Admin\TanimlamalarController::class, 'create'])->name('admin_tanimlamalar_add');
        Route::post('store', [App\Http\Controllers\Admin\TanimlamalarController::class, 'store'])->name('admin_tanimlamalar_store');
        Route::get('edit/{id}', [App\Http\Controllers\Admin\TanimlamalarController::class, 'edit'])->name('admin_tanimlamalar_edit');
        Route::post('update/{id}', [App\Http\Controllers\Admin\TanimlamalarController::class, 'update'])->name('admin_tanimlamalar_update');
        Route::get('delete/{yil}', [App\Http\Controllers\Admin\TanimlamalarController::class, 'destroy'])->name('admin_tanimlamalar_delete');
        Route::get('show', [App\Http\Controllers\Admin\TanimlamalarController::class, 'show'])->name('admin_tanimlamalar_show');
    });


    Route::prefix('citydefinition')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\CityDefinitionController::class, 'index'])->name('admin_citydefinition');
        Route::get('create', [App\Http\Controllers\Admin\CityDefinitionController::class, 'create'])->name('admin_citydefinition_add');
        Route::post('store', [App\Http\Controllers\Admin\CityDefinitionController::class, 'store'])->name('admin_citydefinition_store');
        Route::get('edit/{id}', [App\Http\Controllers\Admin\CityDefinitionController::class, 'edit'])->name('admin_citydefinition_edit');
        Route::post('update/{id}', [App\Http\Controllers\Admin\CityDefinitionController::class, 'update'])->name('admin_citydefinition_update');
        Route::get('delete/{id}', [App\Http\Controllers\Admin\CityDefinitionController::class, 'destroy'])->name('admin_citydefinition_delete');
        Route::get('show', [App\Http\Controllers\Admin\CityDefinitionController::class, 'show'])->name('admin_citydefinition_show');
    });



});



Route::get('/', [HomeController::class, 'index']);

Route::get('/home', [HomeController::class, 'index']);



/*
Route::get('/babasayfa', [HomeController::class, 'baba']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});*/
