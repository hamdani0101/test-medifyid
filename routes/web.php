<?php

use Illuminate\Support\Facades\Route;

use App\Models\KategoriItem;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index']);
Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search']);
Route::get('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formSubmit']);

Route::get('/master-items/view/{kode}', [App\Http\Controllers\MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [App\Http\Controllers\MasterItemsController::class, 'delete']);


Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);


Route::group(['prefix' => 'kategori-items'], function() {
    Route::get('/', [App\Http\Controllers\KategoriController::class, 'index'])->name('kategori-items.index');
    Route::view('/create', 'kategori_items.form.create')->name('kategori-items.create');
    Route::post('/', [App\Http\Controllers\KategoriController::class, 'store'])->name('kategori-items.store');
    Route::get('/print', [App\Http\Controllers\KategoriController::class, 'print'])->name('kategori-items.print');
    Route::get('/{id}', [App\Http\Controllers\KategoriController::class, 'show'])->name('kategori-items.show');
    Route::get('/{id}/edit', function($id){
        $item = KategoriItem::find($id);

        return view('kategori_items.form.update', compact('item'));
    })->name('kategori-items.edit');
    Route::put('/{id}', [App\Http\Controllers\KategoriController::class, 'update'])->name('kategori-items.update');

    Route::delete('/{id}', [App\Http\Controllers\KategoriController::class, 'destroy'])->name('kategori-items.destroy');

    Route::get('/all-items', [App\Http\Controllers\KategoriController::class, 'getAllItems'])->name('kategori-items.all-items');
});
