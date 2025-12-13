<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevenir clickjacking (impede que o site seja incorporado em iframe)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        
        // Prevenir MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Habilitar proteção XSS no navegador
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Content Security Policy - Básico
        $response->headers->set('Content-Security-Policy', 
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://cdn.jsdelivr.net; " .
            "style-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com; " .
            "img-src 'self' data: https:; " .
            "font-src 'self' data:; " .
            "connect-src 'self';"
        );
        
        // Referrer Policy - Não enviar informações sensíveis
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Permissions Policy - Desabilitar recursos não utilizados
        $response->headers->set('Permissions-Policy', 
            'camera=(), microphone=(), geolocation=(), payment=()'
        );

        return $response;
    }
}
