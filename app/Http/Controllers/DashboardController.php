<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillLine;
use App\Models\BillLineOptionValue;
use App\Models\Customer;
use App\Models\Product;
use App\Enums\BillStatus;

class DashboardController extends Controller
{
    public function index()
    {
        $customerStats = $this->getCustomerStats();
        $productsStats = $this->getProductsStats();
        $billStats = $this->getBillStats();

        $recentActivity = Bill::latest()
            ->take(5)
            ->get();

        return view('dashboard.index', [
            ...$customerStats,
            ...$productsStats,
            ...$billStats,
            'recentActivity' => $recentActivity,
        ]);
    }

    private function getCustomerStats()
    {
        return [
            'customerCount'       => Customer::count(),
            'customerCountYear'   => Customer::whereYear('created_at', now()->year)->count(),
            'activeCustomerCount' => Bill::where('created_at', '>=', now()->subYear())
                ->distinct('customer_id')
                ->count('customer_id'),
            'topCustomers'        => $this->topCustomers(),
            'latestCustomers'     => Customer::latest()->limit(3)->get(),
        ];
    }

    private function topCustomers()
    {
        return Bill::where('type', 'invoice')
            ->with('customer')
            ->selectRaw('customer_id, SUM(total) as total_spent')
            ->groupBy('customer_id')
            ->orderByDesc('total_spent')
            ->limit(3)
            ->get();
    }

    private function getProductsStats()
    {
        $topProducts = $this->topProducts();

        return [
            'productCount'  => Product::count(),
            'topProducts'   => $topProducts,
            'bestProduct'   => $topProducts->first(),
            'unusedProducts' => Product::whereDoesntHave('lines')->count(),
            'totalOptionUses' => BillLineOptionValue::count(),
            'topOptions' => $this->topOptions(),
        ];
    }

    private function topProducts()
    {
        return BillLine::selectRaw('product_id, CAST(SUM(quantity) AS UNSIGNED) as total_sold')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(4)
            ->get();
    }

    private function topOptions()
    {
        return BillLineOptionValue::with(['productOptionValue.option'])
            ->selectRaw('product_option_value_id, COUNT(*) as total')
            ->groupBy('product_option_value_id')
            ->orderByDesc('total')
            ->take(2)
            ->get();
    }

    private function getBillStats()
    {
        return [
            'quotesCount'         => Bill::where('type', 'quote')->count(),
            'invoicesCount'       => Bill::where('type', 'invoice')->count(),
            'acceptedQuotes'      => Bill::where('type', 'quote')
                ->where('status', BillStatus::Accepted)
                ->count(),
            'rejectedQuotes'      => Bill::where('type', 'quote')
                ->where('status', BillStatus::Rejected)
                ->count(),
            'convertedQuotes' => Bill::whereNotNull('converted_from_id')->count(),
            'paidInvoices'        => Bill::where('type', 'invoice')
                ->where('status', BillStatus::Paid)
                ->count(),
            'overdueInvoices'     => Bill::where('type', 'invoice')
                ->where('status', BillStatus::Overdue)
                ->count(),
            'totalRevenue'        => Bill::where('type', 'invoice')
                ->where('status', BillStatus::Paid)
                ->sum('total'),
            'yearRevenue'         => Bill::where('type', 'invoice')
                ->where('status', BillStatus::Paid)
                ->whereYear('created_at', now()->year)
                ->sum('total'),
        ];
    }
}
