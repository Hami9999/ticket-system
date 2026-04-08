<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketWidgetController;
use App\Http\Controllers\TicketController;
use App\Http\Middleware\RoleCheck;

// Breeze auth routes
require __DIR__.'/auth.php';

// Public widget
Route::get('/widget', [TicketWidgetController::class, 'show'])->name('widget.show');
Route::post('/api/tickets', [TicketWidgetController::class, 'store'])->name('widget.store');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Admin / manager
    Route::prefix('admin')->group(function () {
        Route::get('/tickets', [TicketController::class, 'index'])
            ->middleware([RoleCheck::class.':admin,manager'])
            ->name('tickets.index');

        Route::get('/tickets/{ticket}', [TicketController::class, 'show'])
            ->middleware([RoleCheck::class.':admin,manager'])
            ->name('tickets.show');

        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])
            ->middleware([RoleCheck::class.':admin'])
            ->name('tickets.destroy');

        Route::post('/tickets/{ticket}/reply', [TicketController::class, 'reply'])
            ->middleware([RoleCheck::class.':manager'])
            ->name('tickets.reply');
    });

    // Profile
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    Route::patch('/profile', function () {
        $user = auth()->user();
        $user->update(request()->only(['name','email']));
        return redirect()->route('profile.edit')->with('success','Profile updated!');
    })->name('profile.update');

    // Dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            return redirect()->route('tickets.index');
        }
        return redirect('/');
    })->name('dashboard');
});
