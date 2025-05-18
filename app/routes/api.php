<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteListController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ControllerTesting;

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

Route::middleware(['api.token'])->group(function () {
    Route::prefix('NoteList')->group(function () {
        Route::get('/GetAll/{id_user}', [NoteListController::class, 'GetAll']);
        Route::get('/GetByIdNoteList/{id_user}/{id_note_lists}', [NoteListController::class, 'GetByIdNoteList']);
        Route::post('/AddNoteList', [NoteListController::class, 'AddNoteList']);
        Route::post('/UpdateNoteList', [NoteListController::class, 'UpdateNoteList']);
    });
});
Route::prefix('Auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

});

Route::prefix('Testing')->group(function () {
    Route::get('/KoneksiDB', [ControllerTesting::class, 'index']);
});