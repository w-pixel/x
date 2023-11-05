<?php

use App\Http\Controllers\PdfController;
use App\Http\Controllers\SecondBot;
use App\Http\Middleware\VerifyCsrfToken;
use Barryvdh\DomPDF\Facade\Pdf;
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

//Route::get('/', [PdfController::class,'index']);
//Route::get('test',[PdfController::class,'test']);

Route::post('/telegram', [PdfController::class,'handleBot'])->withoutMiddleware(VerifyCsrfToken::class);

Route::post('/telegram1',[SecondBot::class,'handle'])->withoutMiddleware(VerifyCsrfToken::class);

Route::get('receipt/{id}',[SecondBot::class,'handleView']);

Route::get('test',[SecondBot::class,'test']);