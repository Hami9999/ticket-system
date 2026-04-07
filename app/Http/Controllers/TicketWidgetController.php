<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketWidgetController extends Controller
{
    /**
     * Show the feedback widget form.
     */
    public function show()
    {
        return view('widget'); // resources/views/widget.blade.php
    }

    /**
     * Handle ticket submission via AJAX.
     */
    public function store(StoreTicketRequest $request): JsonResponse
    {
        // Create or find the customer by email
        $customer = Customer::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'phone' => $request->phone,
            ]
        );

        // Create the ticket
        $ticket = Ticket::create([
            'customer_id' => $customer->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'new', // default status
        ]);

        // Handle optional file upload
        if ($request->hasFile('file')) {
            $ticket->addMediaFromRequest('file')->toMediaCollection('files');
        }

        return response()->json([
            'success' => true,
            'message' => 'Your ticket has been submitted successfully.',
        ]);
    }
}
