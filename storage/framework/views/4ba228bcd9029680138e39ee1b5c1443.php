<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ordem de Serviço</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat text-slate-100"
      style="background-image: url('<?php echo e(asset('images/identity-bg.png')); ?>');">

    <!-- Overlay -->
    <div class="min-h-screen flex items-start justify-center bg-slate-950/40 px-4 pt-80">

        <!-- CARD VIDRO TRANSLÚCIDO -->
        <div
            class="relative w-full max-w-md px-8 py-10 rounded-3xl
                   border border-violet-500/40 shadow-[0_0_40px_rgba(139,92,246,0.5)]"
            style="
                background: linear-gradient(
                    to bottom,
                    rgba(255, 255, 255, 0.03) 0%,
                    rgba(255, 255, 255, 0.015) 40%,
                    rgba(255, 255, 255, 0.02) 100%
                );
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            "
        >

            <!-- Cabeçalho -->
            <div class="relative mb-8 text-left">
                <h1 class="text-xl font-semibold text-slate-50">
                    Acesse o sistema
                </h1>
                <p class="mt-1 text-xs text-slate-400">
                    Entre com seu e-mail e senha.
                </p>
            </div>


            <!-- Erros -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="mb-5 rounded-xl border border-red-500/40 bg-red-950/40 text-red-100 px-4 py-3 text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p>• <?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


            <!-- Formulário -->
            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
                <?php echo csrf_field(); ?>

                <!-- EMAIL -->
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-2 uppercase tracking-[0.16em]">
                        Email
                    </label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400/80">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.125A7.125 7.125 0 0111.625 12h.75A7.125 7.125 0 0119.5 19.125v.375A1.5 1.5 0 0118 21H6a1.5 1.5 0 01-1.5-1.5v-.375z" />
                            </svg>
                        </span>

                        <input
                            type="email"
                            name="email"
                            class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-slate-700/70 bg-slate-900/70
                                   text-slate-100 text-sm placeholder:text-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-violet-500 transition"
                            value="<?php echo e(old('email')); ?>"
                            required
                        >
                    </div>
                </div>


                <!-- SENHA -->
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-2 uppercase tracking-[0.16em]">
                        Senha
                    </label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400/80">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M16.5 10.5V8.25a4.5 4.5 0 00-9 0v2.25M7.5 10.5h9A1.5 1.5 0 0118 12v6.75A1.5 1.5 0 0116.5 20.25h-9A1.5 1.5 0 016 18.75V12a1.5 1.5 0 011.5-1.5z" />
                            </svg>
                        </span>

                        <input
                            type="password"
                            name="password"
                            class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-slate-700/70 bg-slate-900/70
                                   text-slate-100 text-sm placeholder:text-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-violet-500 transition"
                            required
                        >
                    </div>
                </div>


                <!-- LEMBRAR-ME -->
                <div class="flex items-center justify-between text-xs text-slate-300">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox"
                               class="w-4 h-4 rounded bg-slate-900 border-slate-600 text-violet-500 focus:ring-violet-500">
                        <span>Lembrar-me</span>
                    </label>
                </div>


                <!-- BOTÃO DE ENTRAR -->
                <button type="submit"
                    class="w-full mt-2 py-2.5 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-500
                           text-sm font-semibold text-white tracking-wide
                           shadow-[0_0_25px_rgba(139,92,246,0.9)]
                           hover:from-violet-500 hover:to-fuchsia-400
                           active:scale-[0.99] transition">
                    Entrar
                </button>

            </form>

        </div>
    </div>

</body>
</html>
<?php /**PATH C:\Users\Rodri\OneDrive\Área de Trabalho\Sistema de Ordens de Serviço para Assistência Técnica\resources\views/auth/login.blade.php ENDPATH**/ ?>