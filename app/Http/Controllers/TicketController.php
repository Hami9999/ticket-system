<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TicketController extends Controller
{
    // Admin: list all tickets
   public function index(Request $request)
   {
       $this->authorizeRole(['admin', 'manager']);

       $query = Ticket::with('customer')->latest();

       // Filters
       if ($request->filled('status')) {
           $query->where('status', $request->status);
       }

       if ($request->filled('email')) {
           $query->whereHas('customer', function ($q) use ($request) {
               $q->where('email', 'like', "%{$request->email}%");
           });
       }

       if ($request->filled('phone')) {
           $query->whereHas('customer', function ($q) use ($request) {
               $q->where('phone', 'like', "%{$request->phone}%");
           });
       }

       if ($request->filled('date_from')) {
           $query->whereDate('created_at', '>=', $request->date_from);
       }

       if ($request->filled('date_to')) {
           $query->whereDate('created_at', '<=', $request->date_to);
       }

       $tickets = $query->get();

       return view('tickets.index', compact('tickets'));
   }

    // Admin: show ticket details
    public function show(Ticket $ticket)
    {
        $this->authorizeRole(['admin', 'manager']);

        return view('tickets.show', compact('ticket'));
    }

    // Admin: delete ticket
    public function destroy(Ticket $ticket)
    {
        $this->authorizeRole(['admin']);

        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }

    // Manager: reply to ticket
    public function reply(Request $request, Ticket $ticket)
    {
        $this->authorizeRole(['admin','manager']);

        $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->update([
            'status' => 'answered',
            'manager_reply_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Ticket replied successfully.');
    }

    // Helper: check role(s)
    protected function authorizeRole($roles)
    {
        $roles = (array) $roles;
        if (!auth()->user() || !auth()->user()->hasAnyRole($roles)) {
            abort(403, 'Unauthorized');
        }
    }
public function statistics()
{
    $this->authorizeRole(['admin','manager']);

    $now = Carbon::now();

    $daily = Ticket::where('created_at', '>=', $now->copy()->subDay())->count();
    $weekly = Ticket::where('created_at', '>=', $now->copy()->subWeek())->count();
    $monthly = Ticket::where('created_at', '>=', $now->copy()->subMonth())->count();

    return response()->json([
        'daily' => $daily,
        'weekly' => $weekly,
        'monthly' => $monthly,
    ]);
}
}
