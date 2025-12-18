<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo e($title); ?></title>
    <style>
        @page {
            margin: 20mm;
        }
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
        }
        h1 { 
            color: #0d9488; 
            margin-bottom: 10px; 
            font-size: 24px;
        }
        .subtitle {
            color: #6b7280;
            margin-bottom: 20px;
            font-size: 14px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th { 
            background-color: #0d9488; 
            color: white; 
            padding: 10px; 
            text-align: left; 
            font-weight: bold;
        }
        td { 
            padding: 8px; 
            border-bottom: 1px solid #ddd; 
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .total { 
            background-color: #f3f4f6; 
            font-weight: bold; 
        }
        .text-right { 
            text-align: right; 
        }
        .type-cash {
            background-color: #ccfbf1;
            color: #134e4a;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .type-bank {
            background-color: #dbeafe;
            color: #1e3a8a;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .section-header {
            background-color: #0d9488;
            color: white;
            padding: 8px 10px;
            font-weight: bold;
            margin-top: 20px;
        }
        .summary {
            margin-top: 30px;
            padding: 15px;
            background-color: #f0fdfa;
            border-left: 4px solid #0d9488;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <h1><?php echo e($title); ?></h1>
    <div class="subtitle">Dibuat pada: <?php echo e(date('d F Y H:i')); ?> | User: <?php echo e(auth()->user()->name); ?></div>
    
    <?php if($type === 'all' || $type === 'cash'): ?>
        <?php if($cashExpenses->count() > 0): ?>
            <div class="section-header">PENGELUARAN CASH</div>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Kategori</th>
                        <th class="text-right">Jumlah</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $cashExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($expense->date->format('d/m/Y')); ?></td>
                            <td><?php echo e(htmlspecialchars($expense->description)); ?></td>
                            <td><?php echo e(htmlspecialchars($expense->category)); ?></td>
                            <td class="text-right">Rp <?php echo e(number_format($expense->amount, 0, ',', '.')); ?></td>
                            <td><?php echo e(htmlspecialchars($expense->notes ?? '-')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr class="total">
                        <td colspan="3"><strong>Subtotal Cash</strong></td>
                        <td class="text-right"><strong>Rp <?php echo e(number_format($cashExpenses->sum('amount'), 0, ',', '.')); ?></strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php if($type === 'all' || $type === 'bank'): ?>
        <?php if($bankExpenses->count() > 0): ?>
            <div class="section-header">PENGELUARAN BANK</div>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Kategori</th>
                        <th class="text-right">Jumlah</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $bankExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($expense->date->format('d/m/Y')); ?></td>
                            <td><?php echo e(htmlspecialchars($expense->description)); ?></td>
                            <td><?php echo e(htmlspecialchars($expense->category)); ?></td>
                            <td class="text-right">Rp <?php echo e(number_format($expense->amount, 0, ',', '.')); ?></td>
                            <td><?php echo e(htmlspecialchars($expense->notes ?? '-')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr class="total">
                        <td colspan="3"><strong>Subtotal Bank</strong></td>
                        <td class="text-right"><strong>Rp <?php echo e(number_format($bankExpenses->sum('amount'), 0, ',', '.')); ?></strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php if($cashExpenses->count() == 0 && $bankExpenses->count() == 0): ?>
        <p style="text-align: center; padding: 40px; color: #6b7280;">Tidak ada data pengeluaran untuk periode ini.</p>
    <?php else: ?>
        <div class="summary">
            <div class="summary-item">
                <span><strong>Total Cash:</strong></span>
                <span><strong>Rp <?php echo e(number_format($cashExpenses->sum('amount'), 0, ',', '.')); ?></strong></span>
            </div>
            <div class="summary-item">
                <span><strong>Total Bank:</strong></span>
                <span><strong>Rp <?php echo e(number_format($bankExpenses->sum('amount'), 0, ',', '.')); ?></strong></span>
            </div>
            <div class="summary-item" style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #0d9488;">
                <span style="font-size: 18px;"><strong>GRAND TOTAL:</strong></span>
                <span style="font-size: 18px;"><strong>Rp <?php echo e(number_format($totalAmount, 0, ',', '.')); ?></strong></span>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/KeuanganPajakChaste/resources/views/expenses/export-pdf.blade.php ENDPATH**/ ?>