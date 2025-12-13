<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Ordem de Serviço'); ?></title>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-accent': '#4F46E5',
                        'brand-accent-soft': '#312E81',
                        'brand-text-primary': '#F9FAFB',
                        'brand-text-muted': '#9CA3AF',
                        'brand-text-soft': '#6B7280',
                        'brand-border-subtle': '#1E293B',
                        'brand-border-strong': '#4C1D95',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* App background image: place your image at public/images/identity-bg.png */
        body.app-bg {
            background-image: url('<?php echo e(asset("images/identity-bg.png")); ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Optional overlay: adjust opacity/color in case text needs more contrast */
        .app-bg-overlay {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.05) 0%, rgba(76, 29, 149, 0.05) 100%);
            min-height: 100vh;
        }

        /* Glass morphism effect for cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px 0 rgba(79, 70, 229, 0.12);
        }

        .glass-table {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-table thead {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.92), rgba(76, 29, 149, 0.92));
        }

        .glass-table tbody tr:hover {
            background: rgba(79, 70, 229, 0.08);
        }

        /* Better title visibility */
        .page-title {
            color: #f9fafb;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8), 0 0 20px rgba(79, 70, 229, 0.4);
        }
    </style>
</head>
<body class="app-bg">
    <nav class="bg-gradient-to-r from-brand-accent via-purple-700 to-brand-border-strong shadow-2xl backdrop-blur-sm bg-opacity-95">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-3 group">
                    <div class="p-2 bg-white bg-opacity-10 rounded-lg group-hover:bg-opacity-20 transition-all duration-300">
                        <svg class="w-7 h-7 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white drop-shadow-lg tracking-tight">Ordem de Serviço</h1>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-2 px-4 py-2 bg-white bg-opacity-10 rounded-lg backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm text-white font-medium"><?php echo e(Auth::user()->name); ?></span>
                        </div>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="px-4 py-2 bg-red-500 bg-opacity-90 hover:bg-opacity-100 text-white rounded-lg font-medium transition-all duration-200 hover:shadow-lg hover:scale-105 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Sair</span>
                            </button>
                        </form>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto app-bg-overlay">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <div class="flex gap-4 my-6">
                <a href="<?php echo e(route('ordensservico.index')); ?>" class="px-4 py-2 bg-brand-accent text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">Listar Ordens</a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->isAdmin()): ?>
                <a href="<?php echo e(route('ordensservico.create')); ?>" class="px-4 py-2 bg-brand-border-strong text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">Nova Ordem</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="<?php echo e(route('clientes.index')); ?>" class="px-4 py-2 bg-brand-accent text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">Clientes</a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->isAdmin()): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-4 py-2 bg-brand-border-strong text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">Dashboard</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- Modal de Confirmação -->
    <div x-data="{ 
        showModal: false, 
        modalTitle: '', 
        modalMessage: '', 
        modalAction: null,
        confirmDelete(title, message, formId) {
            this.modalTitle = title;
            this.modalMessage = message;
            this.modalAction = formId;
            this.showModal = true;
        },
        executeDelete() {
            if (this.modalAction) {
                document.getElementById(this.modalAction).submit();
            }
            this.showModal = false;
        }
    }" 
    x-on:confirm-delete.window="confirmDelete($event.detail.title, $event.detail.message, $event.detail.formId)"
    x-cloak>
        <div x-show="showModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" 
                 @click="showModal = false"></div>
            
            <!-- Modal -->
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all"
                     @click.away="showModal = false">
                    <!-- Ícone de Aviso -->
                    <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    
                    <!-- Título -->
                    <h3 class="text-xl font-bold text-gray-900 text-center mb-2" x-text="modalTitle"></h3>
                    
                    <!-- Mensagem -->
                    <p class="text-gray-600 text-center mb-6" x-text="modalMessage"></p>
                    
                    <!-- Botões -->
                    <div class="flex gap-3">
                        <button @click="showModal = false" 
                                type="button"
                                class="flex-1 px-4 py-2.5 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                            Cancelar
                        </button>
                        <button @click="executeDelete()" 
                                type="button"
                                class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                            Excluir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // Função global para confirmar exclusão
        function confirmDelete(title, message, formId) {
            window.dispatchEvent(new CustomEvent('confirm-delete', {
                detail: { title, message, formId }
            }));
        }

        // Máscara para CPF
        function maskCPF(value) {
            return value
                .replace(/\D/g, '')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }

        // Máscara para Telefone
        function maskPhone(value) {
            value = value.replace(/\D/g, '');
            if (value.length <= 10) {
                return value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else {
                return value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
            }
        }

        // Aplicar máscaras quando o documento carregar
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            const telefoneInput = document.getElementById('telefone');

            if (cpfInput) {
                cpfInput.addEventListener('input', function(e) {
                    e.target.value = maskCPF(e.target.value);
                });
            }

            if (telefoneInput) {
                telefoneInput.addEventListener('input', function(e) {
                    e.target.value = maskPhone(e.target.value);
                });
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\Rodri\OneDrive\Área de Trabalho\Sistema de Ordens de Serviço para Assistência Técnica\resources\views/layouts/app.blade.php ENDPATH**/ ?>