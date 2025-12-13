

<?php $__env->startSection('title', 'Clientes'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold page-title">Clientes</h2>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->isAdmin()): ?>
        <a href="<?php echo e(route('clientes.create')); ?>" class="px-4 py-2 bg-brand-border-strong text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">+ Novo Cliente</a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($clientes->isEmpty()): ?>
            <div class="p-6 text-center">
                <p class="text-gray-500 mb-4">Nenhum cliente cadastrado</p>
                <a href="<?php echo e(route('clientes.create')); ?>" class="text-blue-600 hover:text-blue-800">Cadastrar o primeiro cliente</a>
            </div>
        <?php else: ?>
            <table class="w-full glass-table rounded-xl overflow-hidden">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Nome</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Telefone</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">CPF</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($cliente->nome); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($cliente->email); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($cliente->telefone); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($cliente->cpf); ?></td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="<?php echo e(route('clientes.show', $cliente)); ?>" class="text-blue-600 hover:text-blue-800">Ver Perfil</a>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->isAdmin()): ?>
                                <a href="<?php echo e(route('clientes.edit', $cliente)); ?>" class="text-yellow-600 hover:text-yellow-800">Editar</a>
                                <form id="delete-cliente-<?php echo e($cliente->id); ?>" method="POST" action="<?php echo e(route('clientes.destroy', $cliente)); ?>" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" class="text-red-600 hover:text-red-800" onclick="confirmDelete('Excluir Cliente', 'Tem certeza que deseja excluir <?php echo e($cliente->nome); ?>?', 'delete-cliente-<?php echo e($cliente->id); ?>')">Deletar</button>
                                </form>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rodri\OneDrive\Área de Trabalho\Sistema de Ordens de Serviço para Assistência Técnica\resources\views/clientes/index.blade.php ENDPATH**/ ?>