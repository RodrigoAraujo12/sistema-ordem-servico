<?php

namespace App\Http\Controllers;

use App\Models\OrdemServico;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // Get selected month/year or default to current
        $selectedMonth = request('month', Carbon::now()->format('Y-m'));
        $showAll = request('month') === 'all';
        
        if ($showAll) {
            $startDate = null;
            $endDate = null;
        } else {
            $startDate = Carbon::parse($selectedMonth)->startOfMonth();
            $endDate = Carbon::parse($selectedMonth)->endOfMonth();
        }

        // Total faturado: soma de valor_aprovado de ordens concluídas/entregues
        $totalFaturado = OrdemServico::whereIn('status', ['concluido', 'entregue'])
            ->sum('valor_aprovado');

        // Total recebido (todos os pagamentos)
        $totalRecebido = \App\Models\Pagamento::sum('valor');

        // A receber total
        $totalAReceber = max(0, $totalFaturado - $totalRecebido);

        // Recebido no período (soma dos pagamentos pela data_pagamento)
        $queryPagamentos = \App\Models\Pagamento::query();
        
        if (!$showAll) {
            $queryPagamentos->whereBetween('data_pagamento', [$startDate, $endDate]);
        }
        
        $recebidoPeriodo = $queryPagamentos->sum('valor');

        // Contagem de ordens concluídas no período (pela data de saída)
        $queryCount = OrdemServico::whereIn('status', ['concluido', 'entregue'])
            ->whereNotNull('data_saida');
        
        if (!$showAll) {
            $queryCount->whereBetween('data_saida', [$startDate, $endDate]);
        }
        
        $ordensConcluidasMes = $queryCount->count();

        $ticketMedioMes = $ordensConcluidasMes > 0 ? round($recebidoPeriodo / $ordensConcluidasMes, 2) : 0;

        // Por status no período
        $queryStatus = OrdemServico::selectRaw('status, COUNT(*) as total');
        
        if (!$showAll) {
            $queryStatus->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        $porStatusMes = $queryStatus->groupBy('status')->pluck('total', 'status');

        // Top técnicos por receita no período
        $queryTecnicos = OrdemServico::selectRaw('tecnico_id, SUM(valor_aprovado) as receita, COUNT(*) as ordens')
            ->whereIn('status', ['concluido', 'entregue'])
            ->whereNotNull('data_saida');
        
        if (!$showAll) {
            $queryTecnicos->whereBetween('data_saida', [$startDate, $endDate]);
        }
        
        $topTecnicosMes = $queryTecnicos->groupBy('tecnico_id')
            ->with('tecnico')
            ->orderByDesc('receita')
            ->limit(5)
            ->get();

        // Recebido mensal últimos 12 meses (baseada em pagamentos)
        $monthsList = collect(range(0, 11))
            ->map(fn($i) => Carbon::now()->subMonths($i)->format('Y-m'))
            ->reverse()
            ->values();

        $recebidoPorMesRaw = \App\Models\Pagamento::where('data_pagamento', '>=', $monthsList->first() . '-01')
            ->selectRaw("strftime('%Y-%m', data_pagamento) as ym, SUM(valor) as recebido")
            ->groupBy('ym')
            ->pluck('recebido', 'ym');

        $recebidoPorMes = $monthsList->map(function ($ym) use ($recebidoPorMesRaw) {
            return (float) ($recebidoPorMesRaw[$ym] ?? 0);
        });

        return view('admin.dashboard', compact(
            'totalFaturado', 'totalRecebido', 'totalAReceber', 'recebidoPeriodo', 'ordensConcluidasMes', 'ticketMedioMes', 'porStatusMes', 'topTecnicosMes', 'selectedMonth', 'showAll', 'monthsList', 'recebidoPorMes'
        ));
    }
}
