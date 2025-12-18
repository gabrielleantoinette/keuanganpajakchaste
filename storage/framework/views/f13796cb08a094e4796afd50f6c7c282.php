<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Aplikasi Keuangan Chaste'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gradient-to-br from-teal-50 to-blue-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-gradient-to-r from-teal-600 to-blue-600 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">📊 Aplikasi Keuangan Chaste</h1>
                    <nav class="flex items-center space-x-4">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('expenses.index')); ?>" class="text-white hover:text-teal-100 font-medium transition-colors">
                                Daftar Pengeluaran
                            </a>
                            <a href="<?php echo e(route('expenses.report')); ?>" class="text-white hover:text-teal-100 font-medium transition-colors">
                                Laporan
                            </a>
                            <a href="<?php echo e(route('expenses.create')); ?>" class="bg-white text-teal-600 px-4 py-2 rounded-lg hover:bg-teal-50 transition-colors font-medium shadow-md">
                                + Tambah Pengeluaran
                            </a>
                            <div class="flex items-center space-x-4 border-l border-teal-400 border-opacity-50 pl-4">
                                <span class="text-sm text-white">Halo, <span class="font-semibold"><?php echo e(Auth::user()->name); ?></span></span>
                                <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-red-100 hover:text-white font-medium text-sm transition-colors">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="text-white hover:text-teal-100 font-medium transition-colors">
                                Login
                            </a>
                            <a href="<?php echo e(route('register')); ?>" class="bg-white text-teal-600 px-4 py-2 rounded-lg hover:bg-teal-50 transition-colors font-medium shadow-md">
                                Daftar
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Flash Messages -->
            <?php if(session('success')): ?>
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline"><?php echo e(session('error')); ?></span>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <p class="text-center text-gray-600 text-sm">
                    &copy; <?php echo e(date('Y')); ?> Aplikasi Keuangan Chaste. Dibuat dengan Laravel & Tailwind CSS.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KeuanganPajakChaste/resources/views/layouts/app.blade.php ENDPATH**/ ?>