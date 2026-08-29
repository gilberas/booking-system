<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereHas('roles', fn ($q) => $q->where('slug', 'registered-customer'))
            ->with('customerProfile');

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%");
            });
        }

        $customers = $query->withCount('bookings')->latest()->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $customer->load(['customerProfile', 'bookings' => fn ($q) => $q->latest()->take(10)]);

        return view('admin.customers.show', compact('customer'));
    }
}
