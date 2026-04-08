<x-app-layout>
    <x-slot name="header">
        Ticket #{{ $ticket->id }}
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 space-y-4">
        <div><strong>Customer:</strong> {{ $ticket->customer->name ?? 'N/A' }}</div>
        <div><strong>Email:</strong> {{ $ticket->customer->email ?? 'N/A' }}</div>
        <div><strong>Subject:</strong> {{ $ticket->subject }}</div>
        <div><strong>Status:</strong> {{ ucfirst($ticket->status) }}</div>
        <div><strong>Message:</strong> {{ $ticket->message }}</div>

        @if($ticket->getMedia()->count())
            <div><strong>Files:</strong>
                <ul>
                    @foreach($ticket->getMedia() as $file)
                        <li><a href="{{ $file->getUrl() }}" class="text-blue-600 hover:underline">{{ $file->file_name }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</x-app-layout>
