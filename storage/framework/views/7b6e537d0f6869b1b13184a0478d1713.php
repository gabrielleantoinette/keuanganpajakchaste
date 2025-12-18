<?php $__env->startSection('title', 'Laporan Pengeluaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">📊 Generate Laporan Pengeluaran</h2>
        
        <form method="GET" action="<?php echo e(route('expenses.export')); ?>" id="reportForm" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Filter Periode -->
                <div>
                    <label for="filter" class="block text-sm font-medium text-gray-700 mb-2">
                        Filter Periode <span class="text-red-500">*</span>
                    </label>
                    <select name="filter" id="filter" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="">Pilih Periode</option>
                        <option value="daily">Harian</option>
                        <option value="monthly">Bulanan</option>
                        <option value="yearly">Tahunan</option>
                        <option value="all">Semua</option>
                    </select>
                </div>
                
                <!-- Input Periode -->
                <div id="period-input" style="display: none;">
                    <label for="period" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Periode <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="period" 
                           id="period" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>
                
                <!-- Tipe Transaksi -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe Transaksi <span class="text-red-500">*</span>
                    </label>
                    <select name="type" id="type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="all">Semua (Cash & Bank)</option>
                        <option value="cash">Cash</option>
                        <option value="bank">Bank</option>
                    </select>
                </div>
            </div>
            
            <div class="flex gap-4 pt-4">
                <button type="submit" 
                        class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium shadow-md inline-flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Download Laporan PDF
                </button>
                <button type="button" 
                        onclick="document.getElementById('reportForm').reset(); document.getElementById('period-input').style.display='none';"
                        class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Reset Form
                </button>
            </div>
        </form>
    </div>
    
    <!-- Info Card -->
    <div class="bg-gradient-to-r from-teal-50 to-blue-50 rounded-lg shadow-md p-6 border border-teal-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">💡 Informasi</h3>
        <ul class="space-y-2 text-sm text-gray-700">
            <li class="flex items-start">
                <span class="mr-2">•</span>
                <span>Pilih periode laporan yang diinginkan (Harian/Bulanan/Tahunan/Semua)</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">•</span>
                <span>Pilih tipe transaksi (Cash, Bank, atau Semua)</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">•</span>
                <span>Klik "Download Laporan PDF" untuk mengunduh laporan dalam format PDF</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">•</span>
                <span>Laporan akan langsung terunduh ke perangkat Anda</span>
            </li>
        </ul>
    </div>
</div>

<script>
    document.getElementById('filter').addEventListener('change', function() {
        const periodInput = document.getElementById('period-input');
        const periodField = document.getElementById('period');
        
        if (this.value === 'daily') {
            periodInput.style.display = 'block';
            periodField.type = 'date';
            periodField.required = true;
        } else if (this.value === 'monthly') {
            periodInput.style.display = 'block';
            periodField.type = 'month';
            periodField.required = true;
        } else if (this.value === 'yearly') {
            periodInput.style.display = 'block';
            periodField.type = 'number';
            periodField.min = '2020';
            periodField.max = '2050';
            periodField.placeholder = 'Tahun (contoh: 2024)';
            periodField.required = true;
        } else if (this.value === 'all') {
            periodInput.style.display = 'none';
            periodField.required = false;
            periodField.value = '';
        } else {
            periodInput.style.display = 'none';
            periodField.required = false;
        }
    });
    
    // Set default values
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        const filter = document.getElementById('filter').value;
        const period = document.getElementById('period').value;
        const periodInput = document.getElementById('period-input');
        
        if (filter !== 'all' && periodInput.style.display !== 'none' && !period) {
            e.preventDefault();
            alert('Harap pilih periode terlebih dahulu!');
            return false;
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KeuanganPajakChaste/resources/views/expenses/report.blade.php ENDPATH**/ ?>