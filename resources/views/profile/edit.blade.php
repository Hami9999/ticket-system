<x-app-layout>
    <x-slot name="header">
        Profile
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="name">Name</label>
                <input id="name" name="name" value="{{ auth()->user()->name }}" class="border p-2 rounded w-full">
            </div>
            <div class="mb-4">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ auth()->user()->email }}" class="border p-2 rounded w-full">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
        </form>
    </div>
</x-app-layout>
