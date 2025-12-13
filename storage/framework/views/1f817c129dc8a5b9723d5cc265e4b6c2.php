

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold page-title">Dashboard</h2>
        <div class="flex gap-3 items-center">
            <form method="GET" action="<?php echo e(route('admin.dashboard')); ?>" class="flex gap-3">
                <select name="month" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-accent bg-white">
                    <option value="all" <?php if($showAll): echo 'selected'; endif; ?>>Todos os Meses</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i < 12; $i++): ?>
                        <?php
                            $month = \Carbon\Carbon::now()->subMonths($i)->format('Y-m');
                            $label = \Carbon\Carbon::parse($month)->translatedFormat('F Y');
                        ?>
                        <option value="<?php echo e($month); ?>" <?php if($selectedMonth === $month && !$showAll): echo 'selected'; endif; ?>><?php echo e(ucfirst($label)); ?></option>
                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </form>
            <a href="<?php echo e(route('ordensservico.index')); ?>" class="px-4 py-2 bg-brand-accent text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">Ver Ordens</a>
        </div>
    </div>

    <!-- Métricas Principais -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="glass-card rounded-2xl p-6">
            <p class="text-gray-600 text-sm">Total Faturado</p>
            <p class="text-2xl font-bold text-gray-900">R$ <?php echo e(number_format($totalFaturado ?? 0, 2, ',', '.')); ?></p>
            <p class="text-xs text-gray-500 mt-1">Ordens concluídas/entregues</p>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <p class="text-gray-600 text-sm">Total Recebido</p>
            <p class="text-2xl font-bold text-green-600">R$ <?php echo e(number_format($totalRecebido ?? 0, 2, ',', '.')); ?></p>
            <p class="text-xs text-gray-500 mt-1">Todos os pagamentos</p>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <p class="text-gray-600 text-sm">A Receber</p>
            <p class="text-2xl font-bold text-yellow-600">R$ <?php echo e(number_format($totalAReceber ?? 0, 2, ',', '.')); ?></p>
            <p class="text-xs text-gray-500 mt-1">Faturado - Recebido</p>
        </div>
    </div>

    <!-- Métricas do Período -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="glass-card rounded-2xl p-6">
            <p class="text-gray-600 text-sm"><?php echo e($showAll ? 'Recebido (Total)' : 'Recebido no Período'); ?></p>
            <p class="text-2xl font-bold text-blue-600">R$ <?php echo e(number_format($recebidoPeriodo ?? 0, 2, ',', '.')); ?></p>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <p class="text-gray-600 text-sm"><?php echo e($showAll ? 'Concluídas (Total)' : 'Concluídas no Período'); ?></p>
            <p class="text-2xl font-bold text-gray-900"><?php echo e($ordensConcluidasMes); ?></p>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <p class="text-gray-600 text-sm"><?php echo e($showAll ? 'Ticket Médio Geral' : 'Ticket Médio do Período'); ?></p>
            <p class="text-2xl font-bold text-gray-900">R$ <?php echo e(number_format($ticketMedioMes ?? 0, 2, ',', '.')); ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ordens por Status (<?php echo e($showAll ? 'Geral' : 'Período'); ?>)</h3>
            <div id="chartStatus" style="min-height: 300px;"></div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($porStatusMes->isEmpty()): ?>
                <p class="text-sm text-gray-500 text-center mt-4">Sem dados no período</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Técnicos por Receita (<?php echo e($showAll ? 'Geral' : 'Período'); ?>)</h3>
            <div id="chartTecnicos" style="min-height: 300px;"></div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($topTecnicosMes->isEmpty()): ?>
                <p class="text-sm text-gray-500 text-center mt-4">Sem dados no período</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 mt-6">
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recebido Mensal (últimos 12 meses)</h3>
            <div id="chartReceita" style="min-height: 320px;"></div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(collect($recebidoPorMes)->sum() == 0): ?>
                <p class="text-sm text-gray-500 text-center mt-4">Sem dados no período</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pie Chart - Status
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$porStatusMes->isEmpty()): ?>
    const statusLabels = <?php echo json_encode($porStatusMes->keys()->map(fn($s) => ucfirst(str_replace('_', ' ', $s)))->values()); ?>;
    const statusData = <?php echo json_encode($porStatusMes->values()); ?>;
    
    const statusChart = new ApexCharts(document.querySelector("#chartStatus"), {
        series: statusData,
        chart: {
            type: 'donut',
            height: 320,
            fontFamily: 'inherit',
        },
        labels: statusLabels,
        colors: ['#4F46E5', '#7C3AED', '#EC4899', '#F59E0B', '#10B981', '#EF4444'],
        legend: {
            position: 'bottom',
            fontSize: '14px',
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '16px',
                            fontWeight: 600,
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val, opts) {
                return opts.w.config.series[opts.seriesIndex]
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " ordens"
                }
            }
        }
    });
    statusChart.render();
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    // Bar Chart - Técnicos
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$topTecnicosMes->isEmpty()): ?>
    const tecnicosLabels = <?php echo json_encode($topTecnicosMes->pluck('tecnico.name')->map(fn($n) => $n ?? 'N/A')); ?>;
    const tecnicosReceita = <?php echo json_encode($topTecnicosMes->pluck('receita')); ?>;
    const tecnicosOrdens = <?php echo json_encode($topTecnicosMes->pluck('ordens')); ?>;
    
    const tecnicosChart = new ApexCharts(document.querySelector("#chartTecnicos"), {
        series: [{
            name: 'Receita',
            data: tecnicosReceita
        }],
        chart: {
            type: 'bar',
            height: 320,
            fontFamily: 'inherit',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '60%',
                borderRadius: 8,
                dataLabels: {
                    position: 'top',
                }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return 'R$ ' + val.toLocaleString('pt-BR', {minimumFractionDigits: 2});
            },
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ['#304758']
            }
        },
        colors: ['#4F46E5'],
        xaxis: {
            categories: tecnicosLabels,
            labels: {
                style: {
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            title: {
                text: 'Receita (R$)',
                style: {
                    fontSize: '14px',
                    fontWeight: 600,
                }
            },
            labels: {
                formatter: function(val) {
                    return 'R$ ' + val.toLocaleString('pt-BR');
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(val, opts) {
                    const index = opts.dataPointIndex;
                    const ordens = tecnicosOrdens[index];
                    return 'R$ ' + val.toLocaleString('pt-BR', {minimumFractionDigits: 2}) + ' (' + ordens + ' ordens)';
                }
            }
        },
        grid: {
            borderColor: '#f1f1f1',
        }
    });
    tecnicosChart.render();
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    // Line Chart - Recebido Mensal 12m
    const receitaLabels = <?php echo json_encode($monthsList->map(fn($m) => \Carbon\Carbon::parse($m.'-01')->translatedFormat('M/y'))); ?>;
    const receitaData = <?php echo json_encode($recebidoPorMes->values()); ?>;
    const receitaChart = new ApexCharts(document.querySelector('#chartReceita'), {
        chart: { type: 'area', height: 340, toolbar: { show: false }, fontFamily: 'inherit' },
        series: [{ name: 'Recebido', data: receitaData }],
        colors: ['#10B981'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.05, stops: [0, 90, 100] } },
        xaxis: { categories: receitaLabels },
        yaxis: {
            labels: { formatter: (val) => 'R$ ' + Number(val).toLocaleString('pt-BR') },
            title: { text: 'Recebido (R$)' }
        },
        tooltip: {
            y: { formatter: (val) => 'R$ ' + Number(val).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) }
        }
    });
    receitaChart.render();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rodri\OneDrive\Área de Trabalho\Sistema de Ordens de Serviço para Assistência Técnica\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>