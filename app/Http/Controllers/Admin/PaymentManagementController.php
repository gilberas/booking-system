<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('method')) {
            $query->where('payment_method', $request->input('method'));
        }

        $payments = $query->latest()->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking', 'user', 'invoice']);

        return view('admin.payments.show', compact('payment'));
    }
}
