<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    // New method to display products
    public function index()
    {
        $products = Product::all(); 
        return view('products.index', compact('products'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'updates_enabled' => 'boolean',
        ]);

        $product = Product::findOrFail($id);
        $product->updates_enabled = $request->has('updates_enabled'); // Set to true if checkbox is checked
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function create()
    {
        return view('products.create');
    }

    /*public function fetchLatestVersion($slug)
    {
        $githubRepo = $slug;
        $githubToken = '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';

        $response = Http::withToken($githubToken)
            ->withOptions(['verify' => false])
            ->get("https://api.github.com/repos/{$githubRepo}/releases/latest");

        if ($response->successful()) {
            $release = $response->json();
            return  $release['tag_name'];
        }

        return null; 
    }*/

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'updates_enabled' => 'boolean',
        ], [
            'slug.unique' => 'The provided slug already exists. Please choose another one.',
        ]);

        // Check if the GitHub repository exists
        $repo = $validated['slug'];
        $githubToken = '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'; // Use environment variable for better security

        try {
            $response = Http::withToken($githubToken)
                ->withOptions(['verify' => false])
                ->get("https://api.github.com/repos/{$repo}");

                if (!$response->successful()) {
                    return back()
                        ->withInput() // Preserve user input
                        ->withErrors(['slug' => 'The repository does not exist. Please provide a correct slug.']);
                }
        } catch (\Exception $e) {
            return back()
            ->withInput()
            ->withErrors(['slug' => 'Failed to check repository: ' . $e->getMessage()]);
        }

        // If the repository exists, create the product
        $product = Product::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'updates_enabled' => $validated['updates_enabled'] ?? false,
        ]);

        // Fetch the latest release from GitHub
        try {
            $client = new Client([
                'base_uri' => 'https://api.github.com/',
                'headers' => [
                    'Authorization' => "token {$githubToken}",
                    'Accept' => 'application/vnd.github.v3+json',
                ],
                'verify' => false,
            ]);
            

            // Fetch the latest release from GitHub
            $response = $client->get("repos/{$repo}/releases/latest");
            $releaseData = json_decode($response->getBody(), true);

            $downloadUrl = $releaseData['zipball_url'];
            $tagVersion = $releaseData['tag_name'];  // Extract tag version

            $repoName = explode('/', $repo)[1];
            $folderPath = "public/ESBlueCorona/releases/{$repoName}";
            Storage::makeDirectory($folderPath);

            // Save the ZIP file on the server
            Storage::disk('public')->put(
                "ESBlueCorona/releases/{$repoName}/{$repoName}.zip",
                $client->get($downloadUrl)->getBody()
            );

            $publicUrl = asset("storage/ESBlueCorona/releases/{$repoName}/{$repoName}.zip");

            // Update the product with the download URL and version
            $product->update([
                'download_url' => $publicUrl,
                'version' => $tagVersion,  // Save the tag version in the database
            ]);

            return redirect()->route('products.index')->with('success', 
                "Product '{$product->name}' created successfully! Download URL: {$publicUrl}");
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 
                'Failed to create product: ' . $e->getMessage());
        }
    }
}
