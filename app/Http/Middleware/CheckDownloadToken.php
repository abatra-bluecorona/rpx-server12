<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDownloadToken
{
    public function handle(Request $request, Closure $next)
    {
        $validToken = config('app.download_token'); // Set a token in .env

        if ($request->query('token') !== $validToken) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
