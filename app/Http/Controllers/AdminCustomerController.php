<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class AdminCustomerController extends Controller
{
    /**
     * Daftar pelanggan (role 'customer') beserta jumlah pesanan mereka.
     */
    public function index(): View
    {
        $customers = User::query()
            ->customer()
            ->withCount('orders')
            ->with('orders:id,customer_id,queue_number,customer_phone,created_at')
            ->whereHas('orders')
            ->orderByDesc('orders_count')
            ->orderBy('id')
            ->get();

        return view('admin.customers', compact('customers'));
    }
}
