<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () { return redirect('/homepage'); });

Route::middleware('auth.verified')->group( function() {

    Route::get('/homepage', function () { return Inertia::render('HomePage'); })->name('homepage');

    Route::get('/s/{section}', [SectionController::class, 'show'])->name('section');

    Route::get('/s/{section}/edit', [SectionController::class, 'edit'])->can('edit sections');
    Route::post('/s/{section}/edit', [SectionController::class, 'save'])->can('edit sections');
    Route::post('/s/{section}/upload', [FileController::class, 'upload'])->can('edit sections');
    Route::post('/s/{section}/reserved', [SectionController::class, 'reserved'])->can('edit sections');
    Route::post('/s/{section}/trashed', [SectionController::class, 'trashed'])->can('edit sections');

});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
