<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\SectionController;

Route::get('/', function () { return redirect('/homepage'); });

Route::middleware('auth.verified')->group( function() {

    Route::get('/homepage', function () { return Inertia::render('HomePage'); })->name('homepage');
    Route::get('/s/{section}', [SectionController::class, 'show']);
    
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
