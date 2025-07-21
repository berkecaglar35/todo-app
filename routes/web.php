<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
    
    Route::middleware(['auth'])->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/tasks/export/pdf', [TaskController::class, 'exportPdf'])->name('tasks.export.pdf');
    
    Route::get('/init-cache', function () {
    Artisan::call('cache:table');
    Artisan::call('migrate', ['--force' => true]);
    return '✅ cache tablosu oluşturuldu!';
});
    Route::get('/init-sessions', function () {
    Artisan::call('session:table');
    Artisan::call('migrate', ['--force' => true]);
    return '✅ sessions tablosu oluşturuldu!';
});
    Route::get('/run-session-migration', function () {
    Artisan::call('session:table');
    Artisan::call('migrate', ['--force' => true]);
    return 'Session migration tamamlandı!';
});
    Route::get('/run-migrations', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migration çalıştırıldı!';
});
    Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

});

require __DIR__.'/auth.php';
