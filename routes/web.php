<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketWidgetController;
use App\Http\Controllers\TicketController;

// ==================
// Widget Blade page
// ==================
Route::get('/widget', [TicketWidgetController::class, 'show'])
    ->name('widget.show');

// API route for submitting tickets via AJAX
Route::post('/api/tickets', [TicketWidgetController::class, 'store'])
    ->name('widget.store');

// ==================
// Ticket system routes (protected by roles)
// ==================
Route::middleware(['auth'])->group(function () {

    // Admin routes – full access
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/admin/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
        Route::delete('/admin/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    });

    // Manager routes – can reply
    Route::middleware(['role:manager'])->group(function () {
        Route::post('/admin/tickets/{ticket}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
    });

});
