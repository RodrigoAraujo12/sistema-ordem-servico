

<?php $__env->startSection('title', 'Ordens de Serviço'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold page-title">Ordens de Serviço</h2>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->isAdmin()): ?>
        <a href="<?php echo e(route('ordensservico.create')); ?>" class="px-4 py-2 bg-brand-border-strong text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">+ Nova Ordem</a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    
    <div class="glass-card rounded-2xl p-6">
        <form method="GET" action="<?php echo e(route('ordensservico.index')); ?>" class="mb-6 flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Buscar por número ou cliente..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Todos os status</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = \App\Models\OrdemServico::STATUS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php if(request('status') === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>
            <button type="submit" class="px-4 py-2 bg-brand-accent text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">
                Buscar
            </button>
            <a href="<?php echo e(route('ordensservico.index')); ?>" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors shadow-md">
                Limpar
            </a>
        </form>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ordensServico->isEmpty()): ?>
            <div class="text-center py-8">
                <p class="text-gray-500">Nenhuma ordem de serviço encontrada.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto rounded-xl">
                <table class="w-full glass-table rounded-xl overflow-hidden">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Número</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Cliente</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Aparelho</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Data Entrada</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $ordensServico; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ordem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-blue-600">
                                    <a href="<?php echo e(route('ordensservico.show', $ordem)); ?>" class="hover:underline">
                                        <?php echo e($ordem->numero_ordem); ?>

                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($ordem->cliente->nome); ?></td>
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
                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($ordem->data_entrada->format('d/m/Y')); ?></td>
                                <td class="px-6 py-4 text-sm space-x-2">
                                    <a href="<?php echo e(route('ordensservico.show', $ordem)); ?>" class="text-blue-600 hover:text-blue-800">Ver</a>
                                    <a href="<?php echo e(route('ordensservico.edit', $ordem)); ?>" class="text-yellow-600 hover:text-yellow-800">Editar</a>
                                    <a href="<?php echo e(route('pdf.gerar', $ordem)); ?>" class="text-red-600 hover:text-red-800">PDF</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <?php echo e($ordensServico->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rodri\OneDrive\Área de Trabalho\Sistema de Ordens de Serviço para Assistência Técnica\resources\views/ordensservico/index.blade.php ENDPATH**/ ?>