

<?php $__env->startSection('title', 'Detalhes da Ordem'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-6">
    <div class="mb-4">
        <a href="<?php echo e(route('ordensservico.index')); ?>" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-brand-accent to-brand-border-strong text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-200 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Voltar para Ordens
        </a>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$ordem): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <p>Ordem de serviço não encontrada!</p>
            <a href="<?php echo e(route('ordensservico.index')); ?>" class="text-red-600 underline">Voltar</a>
        </div>
    <?php else: ?>
    <div class="glass-card rounded-2xl p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-900"><?php echo e($ordem->numero_ordem ?? 'Sem número'); ?></h2>
                <p class="text-gray-600 text-sm">Cliente: <?php echo e($ordem->cliente->nome ?? 'Sem cliente'); ?></p>
            </div>
            <div class="flex gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->isAdmin() || $ordem->tecnico_id === Auth::id()): ?>
                <a href="<?php echo e(route('ordensservico.edit', $ordem)); ?>" class="px-4 py-2 bg-brand-accent text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">Editar</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="<?php echo e(route('pdf.gerar', $ordem)); ?>" class="px-4 py-2 bg-brand-border-strong text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">Baixar PDF</a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Gerais</h3>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Aparelho</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($ordem->aparelho); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Defeito Relatado</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($ordem->defeito_relatado); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Status</dt>
                        <dd class="text-sm">
                            <span class="px-3 py-1 rounded-full text-white text-xs font-medium
                                <?php if($ordem->status === 'concluido' || $ordem->status === 'entregue'): ?> bg-green-500
                                <?php elseif($ordem->status === 'cancelado'): ?> bg-red-500
                                <?php elseif($ordem->status === 'em_reparo'): ?> bg-yellow-500
                                <?php else: ?> bg-blue-500 <?php endif; ?>">
                                <?php echo e($ordem->status_formatado); ?>

                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Valores</h3>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Orçamento</dt>
                        <dd class="text-sm text-gray-900">R$ <?php echo e(number_format($ordem->orcamento ?? 0, 2, ',', '.')); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Valor Aprovado</dt>
                        <dd class="text-sm text-gray-900">R$ <?php echo e(number_format($ordem->valor_aprovado ?? 0, 2, ',', '.')); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Data de Entrada</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($ordem->data_entrada->format('d/m/Y')); ?></dd>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ordem->data_saida): ?>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Data de Saída</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($ordem->data_saida->format('d/m/Y')); ?></dd>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </dl>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ordem->observacoes): ?>
        <div class="mt-6 pt-6 border-t">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Observações</h3>
            <p class="text-sm text-gray-600"><?php echo e($ordem->observacoes); ?></p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Seção Financeira: Pagamentos -->
    <div class="glass-card rounded-2xl p-6 mt-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-900">Financeiro</h3>
            <?php if(Auth::user()->isAdmin()): ?>
            <div x-data="{ open: false }" class="text-right w-full sm:w-auto">
                <button @click="open = !open" type="button" class="inline-flex items-center px-4 py-2 bg-brand-accent text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Adicionar pagamento
                </button>
                <div x-show="open" x-cloak class="mt-4">
                    <form action="<?php echo e(route('pagamentos.store')); ?>" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="ordem_id" value="<?php echo e($ordem->id); ?>">
                        <div>
                            <label for="valor" class="block text-sm font-medium text-gray-700">Valor</label>
                            <input id="valor" name="valor" type="number" step="0.01" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-accent focus:ring-brand-accent" placeholder="0,00">
                        </div>
                        <div>
                            <label for="metodo" class="block text-sm font-medium text-gray-700">Método</label>
                            <select id="metodo" name="metodo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-accent focus:ring-brand-accent">
                                <option value="pix">PIX</option>
                                <option value="cartao">Cartão</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="boleto">Boleto</option>
                            </select>
                        </div>
                        <div>
                            <label for="data_pagamento" class="block text-sm font-medium text-gray-700">Data</label>
                            <input id="data_pagamento" name="data_pagamento" type="date" value="<?php echo e(now()->format('Y-m-d')); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-accent focus:ring-brand-accent">
                        </div>
                        <div class="md:col-span-4">
                            <label for="observacao" class="block text-sm font-medium text-gray-700">Observação</label>
                            <div class="flex gap-4">
                                <textarea id="observacao" name="observacao" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-accent focus:ring-brand-accent" placeholder="Opcional"></textarea>
                                <button type="submit" class="h-10 md:h-auto self-end px-4 py-2 bg-brand-border-strong text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md whitespace-nowrap">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="p-4 rounded-lg bg-white shadow-sm border">
                <div class="text-sm text-gray-600">Valor aprovado</div>
                <div class="text-2xl font-bold text-gray-900">R$ <?php echo e(number_format($ordem->valor_aprovado ?? 0, 2, ',', '.')); ?></div>
            </div>
            <div class="p-4 rounded-lg bg-white shadow-sm border">
                <div class="text-sm text-gray-600">Total pago</div>
                <div class="text-2xl font-bold text-green-600">R$ <?php echo e(number_format($ordem->total_pago ?? 0, 2, ',', '.')); ?></div>
            </div>
            <div class="p-4 rounded-lg bg-white shadow-sm border">
                <div class="text-sm text-gray-600">Saldo a receber</div>
                <div class="text-2xl font-bold <?php echo e(($ordem->saldo_receber ?? 0) > 0 ? 'text-yellow-600' : 'text-gray-900'); ?>">R$ <?php echo e(number_format($ordem->saldo_receber ?? 0, 2, ',', '.')); ?></div>
            </div>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-3">Pagamentos</h4>
            <?php
                $pagamentos = $ordem->pagamentos->sortByDesc('data_pagamento');
                $labelMetodo = function($m) {
                    return [
                        'pix' => 'PIX',
                        'cartao' => 'Cartão',
                        'dinheiro' => 'Dinheiro',
                        'boleto' => 'Boleto',
                    ][$m] ?? ucfirst($m);
                };
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pagamentos->isEmpty()): ?>
                <p class="text-sm text-gray-600">Nenhum pagamento registrado.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full glass-table rounded-lg overflow-hidden">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Data</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Método</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Valor</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Observação</th>
                                <?php if(Auth::user()->isAdmin()): ?>
                                <th class="px-4 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">Ações</th>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pagamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900"><?php echo e(optional($pg->data_pagamento)->format('d/m/Y')); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($labelMetodo($pg->metodo)); ?></td>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">R$ <?php echo e(number_format($pg->valor, 2, ',', '.')); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($pg->observacao); ?></td>
                                    <?php if(Auth::user()->isAdmin()): ?>
                                    <td class="px-4 py-3 text-right">
                                        <form id="delete-pagamento-<?php echo e($pg->id); ?>" action="<?php echo e(route('pagamentos.destroy', $pg)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="button" onclick="confirmDelete('Excluir Pagamento', 'Tem certeza que deseja excluir este pagamento de R$ <?php echo e(number_format($pg->valor, 2, ',', '.')); ?>?', 'delete-pagamento-<?php echo e($pg->id); ?>')" class="px-3 py-1.5 text-sm bg-red-500 text-white rounded-md hover:bg-red-600 shadow">Excluir</button>
                                        </form>
                                    </td>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Seção Histórico de Mudanças -->
    <div class="glass-card rounded-2xl p-6 mt-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Histórico de Alterações</h3>
        <?php
            $historico = $ordem->historico()->with('usuario')->orderByDesc('created_at')->get();
        ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($historico->isEmpty()): ?>
            <p class="text-sm text-gray-600">Nenhuma alteração registrada.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $historico; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex gap-4 p-4 bg-white rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-brand-accent bg-opacity-10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($h->campo_alterado); ?></p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <span class="text-red-600"><?php echo e($h->valor_anterior); ?></span> 
                                        <svg class="w-4 h-4 inline mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                        <span class="text-green-600"><?php echo e($h->valor_novo); ?></span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500"><?php echo e($h->usuario->name ?? 'Sistema'); ?></p>
                                    <p class="text-xs text-gray-400"><?php echo e($h->created_at->format('d/m/Y H:i')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rodri\OneDrive\Área de Trabalho\Sistema de Ordens de Serviço para Assistência Técnica\resources\views/ordensservico/show.blade.php ENDPATH**/ ?>