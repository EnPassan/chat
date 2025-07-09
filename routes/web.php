<?php

use App\Models\User;
use App\Models\Blog;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard',[
        'blog'=> Blog::where('id',1)->first(),
        'user'=> User::where('id',1)->first()

    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
