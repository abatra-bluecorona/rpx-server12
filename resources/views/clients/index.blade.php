@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-5">Clients</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200 shadow-md rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Website URL</th>
                <th class="px-6 py-3">Token</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Active/Inactive</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
            <tr>
                <td class="border px-6 py-3">{{ $client->name }}</td>
                <td class="border px-6 py-3">
                    <a href="{{ $client->website_url }}" target="_blank" class="text-blue-500">{{ $client->website_url }}</a>
                </td>
                <td class="border px-6 py-3">{{ $client->rpx_token }}</td>
                <td class="border px-6 py-3">{{ $client->status }}</td>
                <td class="border px-6 py-3">
                    <form action="{{ route('clients.update', $client->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="checkbox" name="status" value="active" 
                            {{ $client->status === 'active' ? 'checked' : '' }} 
                            onchange="this.form.submit()">
                    </form>
                </td>
                <td class="border px-6 py-3">
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
