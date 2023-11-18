<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Painel\PainelController;
use App\Http\Controllers\Painel\PainelTurmaController;
use App\Http\Controllers\Painel\PainelAlunoController;
use App\Http\Controllers\Painel\PainelFuncionarioController;
use App\Http\Controllers\Painel\PainelImageController;
use App\Http\Controllers\Painel\PainelProfessorController;

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

Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'index');
});

Route::controller(PainelController::class)->middleware('auth')->group(function () {
    Route::get('painel', 'index');
});

Route::controller(PainelAlunoController::class)->prefix('painel')->middleware('auth')->group(function () {
    Route::get('aluno', 'index')->name('aluno.index');
    Route::get('aluno.create', 'create')->name('aluno.create');
    Route::post('aluno.store', 'store')->name('aluno.store');
    Route::get('aluno.edit', 'edit')->name('aluno.edit');
    Route::get('aluno.show', 'show')->name('aluno.show');
    Route::put('aluno.update', 'update')->name('aluno.update');
    Route::get('aluno.destroy/{id}', 'destroy')->name('aluno.destroy');
});

Route::controller(PainelTurmaController::class)->prefix('painel')->group(function () {
    Route::get('turma', 'index')->name('turma.index');
    Route::get('turma.create', 'create')->name('turma.create');
    Route::post('turma.store', 'store')->name('turma.store');
    Route::get('turma.edit/{id}', 'edit')->name('turma.edit');
    Route::get('turma.show/{id}', 'show')->name('turma.show');
    Route::put('turma.update', 'update')->name('turma.update');
    Route::get('turma.destroy/{id}', 'destroy')->name('turma.destroy');
});

Route::controller(PainelProfessorController::class)->prefix('painel')->group(function () {
    Route::get('professor', 'index')->name('professor.index');
    Route::get('professor.create', 'create')->name('professor.create');
    Route::post('professor.store', 'store')->name('professor.store');
    Route::get('professor.edit', 'edit')->name('professor.edit');
    Route::get('professor.show', 'show')->name('professor.show');
    Route::put('professor.update', 'update')->name('professor.update');
    Route::get('professor.destroy/{id}', 'destroy')->name('professor.destroy');
});

Route::controller(PainelFuncionarioController::class)->prefix('painel')->group(function () {
    Route::get('funcionario', 'index')->name('funcionario.index');
    Route::get('funcionario.create', 'create')->name('funcionario.create');
    Route::post('funcionario.store', 'store')->name('funcionario.store');
    Route::get('funcionario.edit', 'edit')->name('funcionario.edit');
    Route::get('funcionario.show', 'show')->name('funcionario.show');
    Route::put('funcionario.update', 'update')->name('funcionario.update');
    Route::get('funcionario.destroy/{id}', 'destroy')->name('funcionario.destroy');
});

Route::controller(PainelImageController::class)->prefix('painel')->group(function () {
    Route::get('imagem/{id}', 'show')->name('imagem');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Auth::routes();
