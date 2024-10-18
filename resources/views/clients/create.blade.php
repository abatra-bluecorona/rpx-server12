<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Client') }}
        </h2>
    </x-slot>

    @section('content')
<div class="container mx-auto mt-10">
    {{-- <h1 class="text-2xl font-bold mb-5">Add New Client</h1> --}}

    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('clients.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Client Name</label>
            <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="website_url" class="block text-sm font-medium text-gray-700">Website URL</label>
            <input type="url" id="website_url" name="website_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="https://example.com">
        </div>

        <button type="submit" class="bg-sky-500 hover:bg-sky-700 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
            Create Client
        </button>
    </form>
</div>
@endsection 
</x-app-layout> 

{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-5">Add New Client</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('clients.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Client Name</label>
            <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="website_url" class="block text-sm font-medium text-gray-700">Website URL</label>
            <input type="url" id="website_url" name="website_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="https://example.com">
        </div>

        <button type="submit" class="bg-sky-500 hover:bg-sky-700 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
            Create Client
        </button>
    </form>
</div>
@endsection --}}
