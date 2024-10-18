<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Product;
use App\Models\SharedSecret;
use Illuminate\Support\Facades\Http;

class LicenseController extends Controller
{
    public function validateLicense(Request $request)
    {
        $rpx_token = $request->input('rpx_token');

        $client = Client::where('rpx_token', $rpx_token)->first();

        if ($client && $client->status == 'active') {
            return response()->json(['message' => 'License is valid'], 200);
        }

        return response()->json(['error' => 'Invalid or inactive license'], 400);
    }
    public function checkUpdates(Request $request)
{
    $rpx_token = $request->input('rpx_token');
    $productSlug = $request->input('product_slug');

    $client = Client::where('rpx_token', $rpx_token)->first();
    if ($client && $client->status == 'active') {
        $product = Product::where('slug', $productSlug)->first();
        if ($product) {
            if ($product->updates_enabled) {
                $githubRepo = $productSlug;
                $githubToken = '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';

                $response = Http::withToken($githubToken)
                    ->withOptions(['verify' => false])
                    ->get("https://api.github.com/repos/{$githubRepo}/releases/latest");

                if ($response->successful()) {
                    $release = $response->json();
                    $changelog = $release['body'] ?? 'No changelog available';

                    return response()->json([
                        'version' => $release['tag_name'],
                        'download_url' => $product->download_url,  // Use the saved download URL
                        'changelog' => $changelog,
                    ], 200);
                }

                return response()->json(['error' => 'Unable to fetch updates from GitHub'], 500);
            }

            return response()->json(['error' => 'Updates disabled for this product'], 403);
        }

        return response()->json(['error' => 'Product not found'], 404);
    }

    return response()->json(['error' => 'Invalid license or updates disabled'], 400);
}

    
    public function fetchSharedSecrets(Request $request) {
        $client = Client::where('rpx_token', $request->input('rpx_token'))->first();
    
        if (!$client || $client->status !== 'active') {
            return response()->json(['error' => 'Invalid rpx_token'], 403);
        }
    
        $sharedSecrets = SharedSecret::all()->pluck('value', 'key');
    
        return response()->json($sharedSecrets);
    }    
}
