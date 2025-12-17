

<?php $__env->startSection('title', 'Perfil do Cliente'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-6">
    <div class="mb-4">
        <a href="<?php echo e(route('clientes.index')); ?>" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-brand-accent to-brand-border-strong text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-200 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Voltar para Clientes
        </a>
    </div>

    <!-- Informações do Cliente -->
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-900"><?php echo e($cliente->nome); ?></h2>
                <p class="text-gray-600 text-sm">Cliente desde <?php echo e($cliente->created_at->format('d/m/Y')); ?></p>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->isAdmin()): ?>
            <a href="<?php echo e(route('clientes.edit', $cliente)); ?>" class="px-4 py-2 bg-brand-accent text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">
                Editar Cliente
            </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Dados de Contato</h3>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Email</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($cliente->email); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Telefone</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($cliente->telefone); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">CPF</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($cliente->cpf); ?></dd>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cliente->endereco): ?>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Endereço</dt>
                        <dd class="text-sm text-gray-900"><?php echo e($cliente->endereco); ?></dd>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Estatísticas</h3>
                <div class="grid grid-cols-1 gap-3">
                    <div class="p-3 rounded-lg bg-blue-50 border border-blue-200">
                        <div class="text-xs text-blue-600 font-medium">Total de Ordens</div>
                        <div class="text-2xl font-bold text-blue-700"><?php echo e($totalOrdens); ?></div>
                    </div>
                    <div class="p-3 rounded-lg bg-green-50 border border-green-200">
                        <div class="text-xs text-green-600 font-medium">Total Gasto</div>
                        <div class="text-2xl font-bold text-green-700">R$ <?php echo e(number_format($totalGasto, 2, ',', '.')); ?></div>
                    </div>
                    <div class="p-3 rounded-lg bg-yellow-50 border border-yellow-200">
                        <div class="text-xs text-yellow-600 font-medium">Ordens em Aberto</div>
                        <div class="text-2xl font-bold text-yellow-700"><?php echo e($ordensAbertas); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Histórico de Ordens -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Histórico de Ordens de Serviço</h3>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ordens->isEmpty()): ?>
            <p class="text-sm text-gray-600 text-center py-8">Nenhuma ordem de serviço cadastrada para este cliente.</p>
        <?php else: ?>
            <div class="overflow-x-auto rounded-xl">
                <table class="w-full glass-table rounded-xl overflow-hidden">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Número</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Aparelho</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Técnico</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Valor</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Data Entrada</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $ordens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ordem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-blue-600">
                                    <a href="<?php echo e(route('ordensservico.show', $ordem)); ?>" class="hover:underline">
                                        <?php echo e($ordem->numero_ordem); ?>

                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($ordem->aparelho); ?></td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-white text-xs font-medium
                                        <?php if($ordem->status === 'concluido' || $ordem->status === 'entregue'): ?> bg-green-500
                                        <?php elseif($ordem->status === 'cancelado'): ?> bg-red-500
                                        <?php elseif($ordem->status === 'em_reparo'): ?> bg-yellow-500
                                        <?php else: ?> bg-blue-500 <?php endif; ?>">
                                        <?php echo e($ordem->status_formatado); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($ordem->tecnico->name ?? 'Não atribuído'); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-900">R$ <?php echo e(number_format($ordem->valor_aprovado ?? 0, 2, ',', '.')); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($ordem->data_entrada->format('d/m/Y')); ?></td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="<?php echo e(route('ordensservico.show', $ordem)); ?>" class="text-blue-600 hover:text-blue-800">Ver Detalhes</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rodri\OneDrive\Área de Trabalho\Sistema de Ordens de Serviço para Assistência Técnica\resources\views/clientes/show.blade.php ENDPATH**/ ?>