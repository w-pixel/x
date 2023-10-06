<?php

use App\Http\Controllers\PdfController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PdfController::class,'index']);
Route::post('/telegram', [PdfController::class,'handleBot'])->withoutMiddleware(VerifyCsrfToken::class);
Route::get('test',[PdfController::class,'test']);