@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">All Tickets</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full table-auto border border-gray-300">
        <thead class="bg-gray-200">
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Customer</th>
                <th class="border px-4 py-2">Subject</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Created At</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2">{{ $ticket->id }}</td>
                    <td class="border px-4 py-2">{{ $ticket->customer->name }} ({{ $ticket->customer->email }})</td>
                    <td class="border px-4 py-2">{{ $ticket->subject }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($ticket->status) }}</td>
                    <td class="border px-4 py-2">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                    <td class="border px-4 py-2 flex gap-2">
                        <a href="{{ route('tickets.show',$ticket) }}" class="bg-blue-500 text-white px-2 py-1 rounded">View</a>
                        @role('admin')
                        <form action="{{ route('tickets.destroy',$ticket) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        </form>
                        @endrole
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
