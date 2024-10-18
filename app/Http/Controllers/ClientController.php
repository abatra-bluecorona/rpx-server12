<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    // Display the client creation form
    public function create()
    {
        return view('clients.create'); // This will point to the view we will create next
    }

    public function index(Request $request)
    {
        // Fetch all clients
        $clients = Client::all();
    
        // Return a view with the clients
        return view('clients.index', compact('clients'));
    }

    public function update(Request $request, Client $client)
    {
        // Set status based on checkbox value
        $client->status = $request->input('status') ? 'active' : 'inactive';
        $client->save(); // Save the updated status

        return redirect()->route('clients.index')->with('success', 'Client status updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully!');
    }

    public function store(Request $request)
    {
        
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website_url' => 'nullable|url' // Validate the website URL
        ]);

        // Generate a unique license key
        $rpx_token = 'RPX' . bin2hex(random_bytes(16));

        // Create the client
        $client = Client::create([
            'name' => $validated['name'],
            'website_url' => $validated['website_url'], // Save the website URL
            'rpx_token' => $rpx_token,
            'status' => 'active', // Default to active
        ]);

        // Check if the request expects a JSON response (API request)
        if ($request->is('api/*')) {
            // Return the client with rpx_token in JSON format for API requests
            return response()->json([
                'message' => 'Client created successfully!',
                'client_id' => $client->id,
                'rpx_token' => $client->rpx_token,  // Include the rpx_token in the response
            ], 201);
        }

        // Redirect to the clients index page for web requests
        return redirect()->route('clients.index')->with('success', 'Client added successfully!');

    }
}
