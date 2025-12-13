<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login()
    {
        Log::info('LOGIN INICIADO', [
            'method' => request()->method(),
            'url' => request()->fullUrl(),
            'ip' => request()->ip(),
            'has_session' => request()->hasSession(),
        ]);

        $credentials = request()->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        Log::info('VALIDAÇÃO OK', ['email' => request()->input('email')]);

        // Sanitizar email
        $credentials['email'] = filter_var($credentials['email'], FILTER_SANITIZE_EMAIL);

        // Verificar se usuário existe
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        Log::info('USUÁRIO ENCONTRADO?', ['exists' => $user ? 'SIM' : 'NÃO', 'email' => $credentials['email']]);

        if (Auth::attempt($credentials, request()->boolean('remember'))) {
            // Regenerar session ID para prevenir session fixation
            request()->session()->regenerate();
            
            // Log de acesso bem-sucedido
            Log::info('AUTH ATTEMPT SUCESSO', [
                'user_id' => Auth::id(),
                'email' => $credentials['email'],
                'session_id' => request()->session()->getId(),
                'auth_check' => Auth::check(),
            ]);

            return redirect()->intended('ordensservico');
        }

        // Log de tentativa falha
        Log::warning('AUTH ATTEMPT FALHOU', [
            'email' => $credentials['email'],
            'ip' => request()->ip(),
            'user_exists' => $user ? 'sim' : 'não',
        ]);

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->onlyInput('email');
    }

    public function logout()
    {
        // Log de logout
        Log::info('Logout', [
            'user_id' => Auth::id(),
            'ip' => request()->ip(),
        ]);

        Auth::logout();
        
        // Invalidar sessão e regenerar token
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect('login');
    }
}
