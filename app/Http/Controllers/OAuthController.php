<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class OAuthController extends Controller
{
    public function getAuthorizationUrl()
    {
        $state = Str::random(40);
        session(['oauth_state' => $state]);

        $query = http_build_query([
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'redirect_uri' => env('PASSPORT_REDIRECT_URI'),
            'response_type' => 'code',
            'scope' => '*',
            'state' => $state,
        ]);

        $authUrl = url('/oauth/authorize?' . $query);

        return response()->json([
            'authorization_url' => $authUrl,
            'state' => $state,
        ]);
    }

    public function handleCallback(Request $request)
    {
        if ($request->has('error')) {
            return response()->json([
                'error' => $request->error,
                'error_description' => $request->error_description
            ], 400);
        }

        return response()->json([
            'code' => $request->code,
            'message' => 'Authorization code received successfully',
        ]);
    }

    public function exchangeToken(Request $request)
    {
        // Forward the request to Passport's token endpoint
        $tokenRequest = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'authorization_code',
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'redirect_uri' => env('PASSPORT_REDIRECT_URI'),
            'code' => $request->code,
        ]);

        // Dispatch the request to Laravel's router
        $response = app()->handle($tokenRequest);
        
        return response($response->getContent(), $response->getStatusCode())
            ->header('Content-Type', 'application/json');
    }
}
