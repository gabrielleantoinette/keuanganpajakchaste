<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
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
    <h1>{{ $title }}</h1>
    <div class="subtitle">Dibuat pada: {{ date('d F Y H:i') }} | User: {{ auth()->user()->name }}</div>
    
    @if($type === 'all' || $type === 'cash')
        @if($cashExpenses->count() > 0)
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
                    @foreach($cashExpenses as $expense)
                        <tr>
                            <td>{{ $expense->date->format('d/m/Y') }}</td>
                            <td>{{ htmlspecialchars($expense->description) }}</td>
                            <td>{{ htmlspecialchars($expense->category) }}</td>
                            <td class="text-right">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                            <td>{{ htmlspecialchars($expense->notes ?? '-') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total">
                        <td colspan="3"><strong>Subtotal Cash</strong></td>
                        <td class="text-right"><strong>Rp {{ number_format($cashExpenses->sum('amount'), 0, ',', '.') }}</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        @endif
    @endif
    
    @if($type === 'all' || $type === 'bank')
        @if($bankExpenses->count() > 0)
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
                    @foreach($bankExpenses as $expense)
                        <tr>
                            <td>{{ $expense->date->format('d/m/Y') }}</td>
                            <td>{{ htmlspecialchars($expense->description) }}</td>
                            <td>{{ htmlspecialchars($expense->category) }}</td>
                            <td class="text-right">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                            <td>{{ htmlspecialchars($expense->notes ?? '-') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total">
                        <td colspan="3"><strong>Subtotal Bank</strong></td>
                        <td class="text-right"><strong>Rp {{ number_format($bankExpenses->sum('amount'), 0, ',', '.') }}</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        @endif
    @endif
    
    @if($cashExpenses->count() == 0 && $bankExpenses->count() == 0)
        <p style="text-align: center; padding: 40px; color: #6b7280;">Tidak ada data pengeluaran untuk periode ini.</p>
    @else
        <div class="summary">
            <div class="summary-item">
                <span><strong>Total Cash:</strong></span>
                <span><strong>Rp {{ number_format($cashExpenses->sum('amount'), 0, ',', '.') }}</strong></span>
            </div>
            <div class="summary-item">
                <span><strong>Total Bank:</strong></span>
                <span><strong>Rp {{ number_format($bankExpenses->sum('amount'), 0, ',', '.') }}</strong></span>
            </div>
            <div class="summary-item" style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #0d9488;">
                <span style="font-size: 18px;"><strong>GRAND TOTAL:</strong></span>
                <span style="font-size: 18px;"><strong>Rp {{ number_format($totalAmount, 0, ',', '.') }}</strong></span>
            </div>
        </div>
    @endif
</body>
</html>
