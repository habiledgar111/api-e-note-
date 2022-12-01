<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\mahasiswa;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class jwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('token') ?? $request->query('token');
        // $token = $request->get('token');
        if (!$token) {
        //Unauthorized response if token not there
        return response()->json([
        'error' => 'Token not provded.'
        ], 401);
        }
        try {
            $credentials =JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (ExpiredException $e) {
            return response()->json([
            'error' => 'Provided token is expired.'
            ], 400);
        } catch (Exception $e) {
            return response()->json([
            'error' => 'An error while decoding token.'
            ], 400);
        }

        $mahasiswa = mahasiswa::find($credentials->sub);
        $request->mahasiswa = $mahasiswa;

        return $next($request);
    }
}
