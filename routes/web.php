<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\MooraController;
use App\Http\Controllers\NewRankingController;
use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Client routes
Route::get('/', [ClientController::class, 'index'])->name('client.index');
Route::get('/welcome', [ClientController::class, 'welcome'])->name('welcome');
Route::get('/ranking/{id}', [ClientController::class, 'showSpecificRanking'])->name('client.show-ranking');

// Rankings routes
Route::get('/rankings', [NewRankingController::class, 'index'])->name('rankings.index');
Route::get('/rankings/create/new', [NewRankingController::class, 'createNew'])->name('rankings.create.new');
Route::get('/rankings/create', [NewRankingController::class, 'create'])->name('rankings.create');
Route::post('/rankings/create', [NewRankingController::class, 'storeBasic'])->name('rankings.store-basic');
Route::get('/rankings/select-criteria', [NewRankingController::class, 'selectCriteria'])->name('rankings.select-criteria');
Route::post('/rankings/select-criteria', [NewRankingController::class, 'storeCriteriaSelection'])->name('rankings.store-criteria-selection');
Route::get('/rankings/assign-weights', [NewRankingController::class, 'assignWeights'])->name('rankings.assign-weights');
Route::post('/rankings/assign-weights', [NewRankingController::class, 'storeWeights'])->name('rankings.store-weights');
Route::get('/rankings/cancel', [NewRankingController::class, 'cancelRanking'])->name('rankings.cancel');
Route::get('/rankings/back-to-criteria', [NewRankingController::class, 'backToCriteriaSelection'])->name('rankings.back-to-criteria');
Route::get('/rankings/{id}/back-to-weights', [NewRankingController::class, 'backToWeightAssignment'])->name('rankings.back-to-weights');
Route::get('/rankings/{id}/cancel-from-alternatives', [NewRankingController::class, 'cancelRankingFromAlternatives'])->name('rankings.cancel-from-alternatives');
Route::get('/rankings/{id}', [NewRankingController::class, 'show'])->name('rankings.show');

// Ranking alternatives routes
Route::get('/rankings/{id}/alternatives/create', [NewRankingController::class, 'createAlternative'])->name('rankings.alternatives.create');
Route::post('/rankings/{id}/alternatives', [NewRankingController::class, 'storeAlternative'])->name('rankings.alternatives.store');
Route::get('/rankings/{id}/alternatives', [NewRankingController::class, 'listAlternatives'])->name('rankings.alternatives.list');
Route::get('/rankings/{id}/calculate', [NewRankingController::class, 'calculate'])->name('rankings.calculate');

// Admin routes - Protected by authentication
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    
    // Criteria management
    Route::resource('criterias', CriteriaController::class, ['as' => 'admin']);
    Route::patch('criterias/{id}/toggle-active', [CriteriaController::class, 'toggleActive'])->name('admin.criterias.toggle-active');
    
    // Alternative management
    Route::resource('alternatives', AlternativeController::class, ['as' => 'admin']);
});


