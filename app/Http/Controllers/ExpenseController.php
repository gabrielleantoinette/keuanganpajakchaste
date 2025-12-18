<?php

namespace App\Http\Controllers;

use App\Models\CashExpense;
use App\Models\BankExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $period = $request->get('period');
        $type = $request->get('type', 'all'); // all, cash, bank
        
        // Get cash expenses
        $cashQuery = CashExpense::where('user_id', auth()->id());
        // Get bank expenses
        $bankQuery = BankExpense::where('user_id', auth()->id());
        
        // Apply filters to both queries (skip if filter is 'all')
        if ($filter !== 'all') {
            $this->applyFilters($cashQuery, $filter, $period);
            $this->applyFilters($bankQuery, $filter, $period);
        }
        
        // Combine results based on type
        $allExpenses = collect();
        if ($type === 'all' || $type === 'cash') {
            $cashExpenses = $cashQuery->get()->map(function($item) {
                $item->type = 'cash';
                return $item;
            });
            $allExpenses = $allExpenses->merge($cashExpenses);
        }
        if ($type === 'all' || $type === 'bank') {
            $bankExpenses = $bankQuery->get()->map(function($item) {
                $item->type = 'bank';
                return $item;
            });
            $allExpenses = $allExpenses->merge($bankExpenses);
        }
        
        // Sort and paginate manually
        $sortedExpenses = $allExpenses->sortByDesc('date')->sortByDesc('created_at');
        $currentPage = $request->get('page', 1);
        $perPage = 10;
        $expenses = new \Illuminate\Pagination\LengthAwarePaginator(
            $sortedExpenses->forPage($currentPage, $perPage),
            $sortedExpenses->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Calculate totals
        $cashTotal = $this->calculateTotal(CashExpense::class, $filter, $period);
        $bankTotal = $this->calculateTotal(BankExpense::class, $filter, $period);
        $totalExpenses = $cashTotal + $bankTotal;
        
        // Monthly expenses
        $monthlyCash = $this->calculateMonthly(CashExpense::class);
        $monthlyBank = $this->calculateMonthly(BankExpense::class);
        $monthlyExpenses = $monthlyCash + $monthlyBank;
        
        // Daily expenses
        $dailyCash = $this->calculateDaily(CashExpense::class);
        $dailyBank = $this->calculateDaily(BankExpense::class);
        $dailyExpenses = $dailyCash + $dailyBank;
        
        // Yearly expenses
        $yearlyCash = $this->calculateYearly(CashExpense::class);
        $yearlyBank = $this->calculateYearly(BankExpense::class);
        $yearlyExpenses = $yearlyCash + $yearlyBank;

        return view('expenses.index', compact('expenses', 'totalExpenses', 'monthlyExpenses', 'dailyExpenses', 'yearlyExpenses', 'filter', 'period', 'type', 'cashTotal', 'bankTotal'));
    }

    private function applyFilters($query, $filter, $period)
    {
        if ($filter === 'daily' && $period) {
            $query->whereDate('date', $period);
        } elseif ($filter === 'monthly' && $period) {
            $month = date('m', strtotime($period));
            $year = date('Y', strtotime($period));
            $query->whereMonth('date', $month)->whereYear('date', $year);
        } elseif ($filter === 'yearly' && $period) {
            $query->whereYear('date', $period);
        }
    }

    private function calculateTotal($model, $filter, $period)
    {
        $query = $model::where('user_id', auth()->id());
        $this->applyFilters($query, $filter, $period);
        return $query->sum('amount');
    }

    private function calculateMonthly($model)
    {
        return $model::where('user_id', auth()->id())
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');
    }

    private function calculateDaily($model)
    {
        return $model::where('user_id', auth()->id())
            ->whereDate('date', now()->toDateString())
            ->sum('amount');
    }

    private function calculateYearly($model)
    {
        return $model::where('user_id', auth()->id())
            ->whereYear('date', now()->year)
            ->sum('amount');
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:cash,bank',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $data = [
            'user_id' => auth()->id(),
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'category' => $validated['category'],
            'date' => $validated['date'],
            'notes' => $validated['notes'] ?? null,
        ];

        if ($validated['type'] === 'cash') {
            CashExpense::create($data);
        } else {
            BankExpense::create($data);
        }

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function edit($id, Request $request)
    {
        $type = $request->get('type'); // cash or bank
        
        if ($type === 'cash') {
            $expense = CashExpense::where('user_id', auth()->id())->findOrFail($id);
            $expense->type = 'cash';
        } else {
            $expense = BankExpense::where('user_id', auth()->id())->findOrFail($id);
            $expense->type = 'bank';
        }
        
        if ($expense->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $type = $request->get('type'); // cash or bank
        
        if ($type === 'cash') {
            $expense = CashExpense::where('user_id', auth()->id())->findOrFail($id);
        } else {
            $expense = BankExpense::where('user_id', auth()->id())->findOrFail($id);
        }

        if ($expense->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil diupdate!');
    }

    public function destroy($id, Request $request)
    {
        $type = $request->get('type'); // cash or bank
        
        if ($type === 'cash') {
            $expense = CashExpense::where('user_id', auth()->id())->findOrFail($id);
        } else {
            $expense = BankExpense::where('user_id', auth()->id())->findOrFail($id);
        }

        if ($expense->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil dihapus!');
    }
    
    public function export(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $period = $request->get('period');
        $type = $request->get('type', 'all'); // all, cash, bank
        
        // Get cash expenses
        $cashQuery = CashExpense::where('user_id', auth()->id());
        $bankQuery = BankExpense::where('user_id', auth()->id());
        
        // Apply filters (skip if filter is 'all')
        if ($filter !== 'all') {
            $this->applyFilters($cashQuery, $filter, $period);
            $this->applyFilters($bankQuery, $filter, $period);
        }
        
        // Get expenses based on type
        $cashExpenses = collect();
        $bankExpenses = collect();
        
        if ($type === 'all' || $type === 'cash') {
            $cashExpenses = $cashQuery->orderBy('date', 'desc')->get();
        }
        if ($type === 'all' || $type === 'bank') {
            $bankExpenses = $bankQuery->orderBy('date', 'desc')->get();
        }
        
        // Build title
        $typeLabel = $type === 'cash' ? 'Cash' : ($type === 'bank' ? 'Bank' : 'Semua (Cash & Bank)');
        if ($filter === 'daily' && $period) {
            $title = 'Laporan Pengeluaran Harian - ' . date('d F Y', strtotime($period)) . ' - ' . $typeLabel;
        } elseif ($filter === 'monthly' && $period) {
            $title = 'Laporan Pengeluaran Bulanan - ' . date('F Y', strtotime($period)) . ' - ' . $typeLabel;
        } elseif ($filter === 'yearly' && $period) {
            $title = 'Laporan Pengeluaran Tahunan - ' . $period . ' - ' . $typeLabel;
        } elseif ($filter === 'all') {
            $title = 'Laporan Pengeluaran Semua Periode - ' . $typeLabel;
        } else {
            $title = 'Laporan Pengeluaran - ' . $typeLabel;
        }
        
        $totalAmount = $cashExpenses->sum('amount') + $bankExpenses->sum('amount');
        
        return $this->exportPDF($cashExpenses, $bankExpenses, $title, $totalAmount, $type);
    }
    
    public function report()
    {
        return view('expenses.report');
    }
    
    private function exportPDF($cashExpenses, $bankExpenses, $title, $totalAmount, $type)
    {
        $filename = 'laporan-pengeluaran-' . date('Y-m-d') . '.pdf';
        
        $pdf = Pdf::loadView('expenses.export-pdf', compact('cashExpenses', 'bankExpenses', 'title', 'totalAmount', 'type'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download($filename);
    }
}