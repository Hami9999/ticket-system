<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketWidgetController;

// Widget Blade page
Route::get('/widget', [TicketWidgetController::class, 'show'])
    ->name('widget.show');

// API route for submitting tickets via AJAX
Route::post('/api/tickets', [TicketWidgetController::class, 'store'])
    ->name('widget.store');
