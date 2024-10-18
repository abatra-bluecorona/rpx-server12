@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-5">Products</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200 shadow-md rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Slug</th>
                <th class="px-6 py-3">Updates Enabled</th>
                <th class="px-6 py-3">Version</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td class="border px-6 py-3">{{ $product->name }}</td>
                <td class="border px-6 py-3">{{ $product->slug }}</td>
                <td class="border px-6 py-3">
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="checkbox" name="updates_enabled" value="1" 
                            {{ $product->updates_enabled ? 'checked' : '' }} 
                            onchange="this.form.submit()">
                    </form>
                </td>
                <td class="border px-6 py-3">
                    @if( $product->download_url)
                        <a href="{{ $product->download_url }}" 
                           class="text-blue-500 hover:underline" 
                           download>
                            {{ $product->version }}
                        </a>
                    @else
                        N/A
                    @endif
                </td>
                <td class="border px-6 py-3">
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
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
