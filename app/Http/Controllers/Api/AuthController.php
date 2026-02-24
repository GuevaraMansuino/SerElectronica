<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        // Verificar si es una solicitud web (no JSON)
        if (!$request->expectsJson()) {
            // Login web tradicional
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $credentials['email'])->first();
            
            // Verificar credenciales - mensaje genérico para evitar enumeración de usuarios
            // Usar getAuthPassword() para obtener el password sin procesar por el cast 'hashed'
            if (!$user || !Hash::check($credentials['password'], $user->getAuthPassword())) {
                return back()->withErrors([
                    'email' => 'Las credenciales no coinciden.',
                ])->onlyInput('email');
            }

            // Iniciar sesión
            // Capturamos el valor del checkbox 'remember' (true/false)
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            
            return redirect()->intended(route('admin.dashboard'));
        }

        // Login API (JSON)
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->getAuthPassword())) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        // Verificar si es una solicitud web (session-based)
        if (!$request->expectsJson()) {
            // Logout web - invalidate session
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect('/');
        }
        
        // Logout API - delete token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout exitoso']);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
