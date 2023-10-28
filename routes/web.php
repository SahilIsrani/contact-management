<?php

use App\Http\Controllers\ContactsController;
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

Route::get('/',[ContactsController::class,'index'])->name('contacts.index');
Route::delete('/contacts/{contact}',[ContactsController::class,'destroy'])->name('contacts.delete');
Route::post('/contacts/store',[ContactsController::class,'store'])->name('contacts.store');
Route::get('/contacts/create',[ContactsController::class,'create'])->name('contacts.create');
Route::get('/contacts/{contact}/edit',[ContactsController::class,'edit'])->name('contacts.edit');
Route::get('/contacts/download',[ContactsController::class,'download'])->name('contacts.download');
Route::get('/contacts/{contact}',[ContactsController::class,'show'])->name('contacts.show');
Route::put('/contacts/{contact}',[ContactsController::class,'update'])->name('contacts.update');
Route::get('/contacts/excel/upload',[ContactsController::class,'upload'])->name('contacts.excel.upload');
Route::post('/contacts/excel/import',[ContactsController::class,'import'])->name('contacts.excel.import');
Route::get('/contacts/excel/export',[ContactsController::class,'export'])->name('contacts.excel.export');
