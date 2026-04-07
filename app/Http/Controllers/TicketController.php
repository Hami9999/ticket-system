<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Admin: list all tickets
    public function index()
    {
        $this->authorizeRole('admin');

        $tickets = Ticket::with('customer')->latest()->get();
        return view('tickets.index', compact('tickets'));
    }

    // Admin: show ticket details
    public function show(Ticket $ticket)
    {
        $this->authorizeRole('admin');

        return view('tickets.show', compact('ticket'));
    }

    // Admin: delete ticket
    public function destroy(Ticket $ticket)
    {
        $this->authorizeRole('admin');

        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }

    // Manager: reply to ticket
    public function reply(Request $request, Ticket $ticket)
    {
        $this->authorizeRole(['admin', 'manager']);

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
}
