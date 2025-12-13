<?php

namespace App\Http\Controllers;

use App\Models\OrdemServico;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function gerarOrdem(OrdemServico $ordem)
    {
        $ordem->load(['cliente', 'tecnico']);

        $pdf = Pdf::loadView('pdf.ordem-servico', [
            'ordem' => $ordem,
        ]);

        return $pdf->download('ordem-servico-' . $ordem->numero_ordem . '.pdf');
    }

    public function visualizarOrdem(OrdemServico $ordem)
    {
        $ordem->load(['cliente', 'tecnico']);

        $pdf = Pdf::loadView('pdf.ordem-servico', [
            'ordem' => $ordem,
        ]);

        return $pdf->stream('ordem-servico-' . $ordem->numero_ordem . '.pdf');
    }
}
