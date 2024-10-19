<?php

use App\Http\Controllers\Coleta;
use App\Http\Controllers\PaginationController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ProducaoController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group( function () {
    Route::controller(PaginationController::class)->group(function (){
        Route::get('/peoples','people')->name('api.peoples');
        Route::get('/uploads','upload')->name('api.uploads');
        Route::get('/programs','program')->name('api.programs');
        Route::get('/projects','project')->name('api.projects');
        Route::get('/discipline','discipline')->name('api.disciplines');
        Route::get('/production','production')->name('api.production');
        Route::get('/users','user')->name('api.users');
        Route::get('/oriented','oriented')->name('api.orienteds');
    });
    Route::controller(Coleta::class)->group(function (){
        Route::get('/collect/import-progress','importProgress')->name('api.collect.import.progress');
    });
    Route::get('/qualis/{projeto}',[ProducaoController::class,'qualis'])->name('api.qualis');
    Route::get('/report/qualis/',[ProducaoController::class,'reportByProgram'])->name('api.report-qualis');
    Route::get('/report/orientations/',[ReportController::class,'apiOrientations'])->name('api.report-orientations');
    Route::get('/orientadores',[PessoaController::class,'orientadores'])->name('api.pessoas.orientadores');


});




