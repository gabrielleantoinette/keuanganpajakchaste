<?php $__env->startSection('title', 'Daftar Pengeluaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Filter and Export Section -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="GET" action="<?php echo e(route('expenses.index')); ?>" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label for="filter" class="block text-sm font-medium text-gray-700 mb-2">Filter Periode</label>
                <select name="filter" id="filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <option value="all" <?php echo e($filter == 'all' ? 'selected' : ''); ?>>Semua</option>
                    <option value="daily" <?php echo e($filter == 'daily' ? 'selected' : ''); ?>>Harian</option>
                    <option value="monthly" <?php echo e($filter == 'monthly' ? 'selected' : ''); ?>>Bulanan</option>
                    <option value="yearly" <?php echo e($filter == 'yearly' ? 'selected' : ''); ?>>Tahunan</option>
                </select>
            </div>
            
            <div id="period-input" class="flex-1 min-w-[200px]" style="display: <?php echo e(in_array($filter, ['daily', 'monthly', 'yearly']) ? 'block' : 'none'); ?>;">
                <label for="period" class="block text-sm font-medium text-gray-700 mb-2">Pilih Periode</label>
                <input type="<?php echo e($filter == 'yearly' ? 'number' : ($filter == 'monthly' ? 'month' : 'date')); ?>" 
                       name="period" 
                       id="period" 
                       value="<?php echo e($period ?? ''); ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            </div>
            
            <div class="flex-1 min-w-[200px]">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Transaksi</label>
                <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <option value="all" <?php echo e(($type ?? 'all') == 'all' ? 'selected' : ''); ?>>Semua (Cash & Bank)</option>
                    <option value="cash" <?php echo e(($type ?? 'all') == 'cash' ? 'selected' : ''); ?>>Cash</option>
                    <option value="bank" <?php echo e(($type ?? 'all') == 'bank' ? 'selected' : ''); ?>>Bank</option>
                </select>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition-colors font-medium shadow-md">
                    Filter
                </button>
                <a href="<?php echo e(route('expenses.index')); ?>" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Reset
                </a>
            </div>
            
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-teal-100 text-sm font-medium">Total Pengeluaran</p>
                    <p class="text-3xl font-bold mt-2">
                        Rp <?php echo e(number_format($totalExpenses, 0, ',', '.')); ?>

                    </p>
                </div>
                <div class="bg-white bg-opacity-20 p-4 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Pengeluaran Hari Ini</p>
                    <p class="text-3xl font-bold mt-2">
                        Rp <?php echo e(number_format($dailyExpenses ?? 0, 0, ',', '.')); ?>

                    </p>
                </div>
                <div class="bg-white bg-opacity-20 p-4 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Pengeluaran Bulan Ini</p>
                    <p class="text-3xl font-bold mt-2">
                        Rp <?php echo e(number_format($monthlyExpenses, 0, ',', '.')); ?>

                    </p>
                </div>
                <div class="bg-white bg-opacity-20 p-4 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-teal-600 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white text-opacity-90 text-sm font-medium">Pengeluaran Tahun Ini</p>
                    <p class="text-3xl font-bold mt-2">
                        Rp <?php echo e(number_format($yearlyExpenses ?? 0, 0, ',', '.')); ?>

                    </p>
                </div>
                <div class="bg-white bg-opacity-20 p-4 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Expenses Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-teal-50 to-blue-50">
            <h2 class="text-xl font-semibold text-gray-900">Daftar Pengeluaran</h2>
        </div>

        <?php if($expenses->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-teal-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Catatan</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-teal-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($expense->date->format('d M Y')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if(($expense->type ?? 'cash') === 'cash'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-teal-100 text-teal-800">
                                            Cash
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Bank
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($expense->description); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <?php echo e($expense->category); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600">
                                    Rp <?php echo e(number_format($expense->amount, 0, ',', '.')); ?>

                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php echo e(Str::limit($expense->notes, 50)); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="<?php echo e(route('expenses.edit', ['id' => $expense->id, 'type' => $expense->type ?? 'cash'])); ?>" class="text-blue-600 hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="<?php echo e(route('expenses.destroy', ['id' => $expense->id, 'type' => $expense->type ?? 'cash'])); ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengeluaran ini?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <?php echo e($expenses->links('components.pagination-links')); ?>

            </div>
        <?php else: ?>
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengeluaran</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan pengeluaran pertama Anda.</p>
                <div class="mt-6">
                    <a href="<?php echo e(route('expenses.create')); ?>" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700">
                        Tambah Pengeluaran
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('filter').addEventListener('change', function() {
        const periodInput = document.getElementById('period-input');
        const periodField = document.getElementById('period');
        
        if (this.value === 'daily') {
            periodInput.style.display = 'block';
            periodField.type = 'date';
        } else if (this.value === 'monthly') {
            periodInput.style.display = 'block';
            periodField.type = 'month';
        } else if (this.value === 'yearly') {
            periodInput.style.display = 'block';
            periodField.type = 'number';
            periodField.min = '2020';
            periodField.max = '2050';
            periodField.placeholder = 'Tahun (contoh: 2024)';
        } else {
            periodInput.style.display = 'none';
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KeuanganPajakChaste/resources/views/expenses/index.blade.php ENDPATH**/ ?>