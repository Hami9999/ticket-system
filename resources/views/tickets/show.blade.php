@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Ticket #{{ $ticket->id }}</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 border p-4 rounded bg-gray-50">
        <p><strong>Customer:</strong> {{ $ticket->customer->name }} ({{ $ticket->customer->email }})</p>
        <p><strong>Phone:</strong> {{ $ticket->customer->phone }}</p>
        <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
        <p><strong>Message:</strong> {{ $ticket->message }}</p>
        <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
        <p><strong>Created At:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</p>
        @if($ticket->manager_reply_at)
            <p><strong>Replied At:</strong> {{ $ticket->manager_reply_at->format('Y-m-d H:i') }}</p>
        @endif
    </div>

    @role('manager')
    <div class="mt-6">
        <h2 class="text-xl font-semibold mb-2">Reply to Ticket</h2>
        <form action="{{ route('tickets.reply', $ticket) }}" method="POST">
            @csrf
            <textarea name="message" class="w-full border p-2 rounded mb-2" rows="4" placeholder="Your reply..."></textarea>
            @error('message')
                <div class="text-red-500 mb-2">{{ $message }}</div>
            @enderror
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Send Reply</button>
        </form>
    </div>
    @endrole
</div>
@endsection
