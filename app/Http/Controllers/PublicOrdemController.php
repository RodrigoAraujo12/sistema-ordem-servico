<?php

namespace App\Http\Controllers;

use App\Models\OrdemServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicOrdemController extends Controller
{
    /**
     * Exibir ordem de serviço via token público (sem necessidade de login)
     */
    public function show($token)
    {
        // Buscar ordem pelo token
        $ordem = OrdemServico::where('public_token', $token)
            ->with(['cliente', 'tecnico', 'pagamentos'])
            ->first();

        // Validar se existe e se token é válido
        if (!$ordem) {
            abort(404, 'Ordem não encontrada.');
        }

        if (!$ordem->isTokenValid()) {
            abort(403, 'Este link expirou. Entre em contato com a assistência técnica.');
        }

        // Log de acesso público
        Log::info('Acesso público à ordem', [
            'ordem_id' => $ordem->id,
            'numero_ordem' => $ordem->numero_ordem,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('public.ordem-detalhes', compact('ordem'));
    }
}
