@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">All Tickets</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Form -->
    <form method="GET" class="mb-4 flex gap-2 flex-wrap">
        <input type="text" name="email" placeholder="Customer Email" value="{{ request('email') }}" class="border px-2 py-1 rounded">
        <input type="text" name="phone" placeholder="Customer Phone" value="{{ request('phone') }}" class="border px-2 py-1 rounded">
        <select name="status" class="border px-2 py-1 rounded">
            <option value="">All Status</option>
            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="answered" {{ request('status') == 'answered' ? 'selected' : '' }}>Answered</option>
        </select>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="border px-2 py-1 rounded">
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="border px-2 py-1 rounded">
        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Filter</button>
        <a href="{{ route('tickets.index') }}" class="bg-gray-300 px-3 py-1 rounded">Reset</a>
    </form>

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
