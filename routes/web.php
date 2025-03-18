<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('createPost', 'posts.create')
    ->middleware(['auth', 'verified'])
    ->name('posts.create');

Volt::route('posts/{post}/view/create-comment', 'comments.create-comment')
    ->middleware(['auth','verified'])
    ->name('comment.create');

Volt::route('posts/{post}/edit', 'posts.edit-post')
    ->middleware(['auth'])
    ->name('post.edit');

Volt::route('comments/{comment}/edit', 'comments.edit-comment')
    ->middleware(['auth', 'verified'])
    ->name('comment.edit');

Volt::route('posts/{post}/view', 'posts.view-post')->name('post.view');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
