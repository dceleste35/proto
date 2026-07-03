<?php

use App\Http\Controllers\AffichePdfController;
use App\Livewire\Affiches\Editor;
use App\Livewire\Affiches\Index;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/affiches');

Route::livewire('/affiches', Index::class)->name('affiches.index');
Route::livewire('/affiches/create', Editor::class)->name('affiches.create');
Route::livewire('/affiches/{affiche}/edit', Editor::class)->name('affiches.edit');
Route::get('/affiches/{affiche}/pdf', AffichePdfController::class)->name('affiches.pdf');
