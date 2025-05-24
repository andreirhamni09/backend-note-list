<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteListController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteTaskController;

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
        Route::delete('/DeleteNoteList/{id_user}/{id_note_lists}', [NoteListController::class, 'DeleteNoteList']);
    });
    Route::prefix('NoteTask')->group(function () {
        Route::get('/GetAll/{id_note_lists}', [NoteTaskController::class, 'GetAll']);
        Route::get('/GetById/{id_note_task}', [NoteTaskController::class, 'GetById']);        
        Route::post('/AddNoteTask', [NoteTaskController::class, 'AddNoteTask']);
        Route::post('/UpdateNoteTask/{id_note_task}', [NoteTaskController::class, 'UpdateNoteTask']);
        Route::post('/UpdateStatusNoteTask/{id_note_task}', [NoteTaskController::class, 'UpdateStatusNoteTask']);
        Route::delete('/DeleteTask/{id_note_task}', [NoteTaskController::class, 'DeleteTask']);
        // Route::get('/GetByIdNoteTasl/{id_user}/{id_note_lists}/{id_note_list_task}', [NoteListController::class, 'GetByIdNoteList']);
        // Route::post('/AddNoteList', [NoteListController::class, 'AddNoteList']);
        // Route::post('/UpdateNoteList', [NoteListController::class, 'UpdateNoteList']);
        // Route::delete('/DeleteNoteList/{id_user}/{id_note_lists}', [NoteListController::class, 'DeleteNoteList']);
    });
});
Route::prefix('Auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::delete('/logout/{id_user}', [AuthController::class, 'logout']);
    Route::post('/tokenExpired', [AuthController::class, 'tokenExpired']);
});