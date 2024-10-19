<?php

use App\Http\Controllers\Coleta;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ProducaoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Models\ProgPosGrad;
use Illuminate\Support\Facades\DB;
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
    return redirect('dashboard');
})->name('home');

Route::get('/phpinfo', function () {
    phpinfo();
});


Route::middleware(['auth'])->group(function () {

    //Dashboard
    Route::controller(DashboardController::class)->middleware(['role:Administrador|Gestor'])->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Coleta
    Route::controller(Coleta::class)->middleware(['role:Administrador'])->group(function () {
        Route::get('/coleta', 'index')->name('coleta.index');
        Route::post('/coleta', 'store')->name('coleta.store');
    });

    // Pessoas
    Route::controller(PessoaController::class)->group(function () {
        Route::get('/pessoas', 'index')->name('pessoas.index');
        Route::get('/pessoas/{id}', 'show')->name('pessoas.show');
        Route::put('/pessoa/{id}', 'update')->name('pessoas.update');

    });

    // Programa
    Route::controller(ProgramaController::class)->group(function () {
        Route::get('/programa', 'index')->name('programa.index');
        Route::post('/programa', 'store')->name('programa.store');
        Route::get('/programa/search', 'search')->name('programa.search');
        Route::get('/programa/{id}', 'show')->name('programa.show');
        Route::get('/programa/{id}/projetos', 'projetos')->name('programa.projetos');

    });

    // Projetos
    Route::controller(ProjetoController::class)->group(function () {
        Route::get('/projeto', 'index')->name('projeto.index');
        Route::get('/projeto/{id}', 'show')->name('projeto.show');
    });

    // Produções
    Route::controller(ProducaoController::class)->group(function (){
        Route::get('/producao', 'index')->name('producao.index');
        Route::get('/report/qualis/export', 'exportData')->name('report.qualis.export');

    });

    // Disciplinas
    Route::resource('disciplinas', DisciplinaController::class);

    //Relatorios
    Route::controller(ReportController::class)->group(function (){
        Route::get('/report/qualis', 'qualis')->name('report.qualis');
        Route::get('/report/orientations', 'orientations')->name('report.orientations');
    });

    // Usuários
    Route::resource('user', UserController::class)->middleware(['role:Administrador']);

    Route::get('update-dashboard', function () {
        (new \App\Observers\UploadObserver())->updated(null);
        return redirect()->route('dashboard');
    });

});


require __DIR__ . '/template.php';
require __DIR__ . '/auth.php';
