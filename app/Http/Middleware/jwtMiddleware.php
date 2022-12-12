<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\user;
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

        if (!$token) {
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

        $user = user::find($credentials->sub);
        $request->user = $user;
        // $request->email = $user->email;
        // $request->nama = $user->nama;

        // var_dump($user);
        // return $next($request);
        return response()->json([
            "success" => true,
            "message" => "grabbed user by token",
            "user" => $user
            // "user" => ["email" => $request->email,
            //             "nama" => $request->nama]
        ]);
    }
}
