<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        
        // Confiar em proxies (Railway, Cloudflare, etc)
        $middleware->trustProxies(at: '*');
        
        // Validar host (aceitar qualquer host em produção)
        $middleware->validateCsrfTokens(except: [
            '*' // TEMPORÁRIO - desabilitar CSRF
        ]);
        
        // Garantir que session/cookie estão habilitados
        $middleware->encryptCookies(except: []);
        
        // Rate Limiting para APIs e formulários
        $middleware->throttleApi();
        
        // Proteção contra clickjacking
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
