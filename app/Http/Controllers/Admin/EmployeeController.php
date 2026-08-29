<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Hotel;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['user', 'hotel']);

        if ($request->filled('hotel_id')) {
            $query->where('hotel_id', $request->input('hotel_id'));
        }

        $employees = $query->latest()->paginate(20);
        $hotels = Hotel::where('is_active', true)->orderBy('name')->get();

        return view('admin.employees.index', compact('employees', 'hotels'));
    }

    public function create()
    {
        $hotels = Hotel::where('is_active', true)->orderBy('name')->get();

        return view('admin.employees.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'hotel_id' => ['nullable', 'exists:hotels,id'],
            'position' => ['nullable', 'string', 'max:255'],
            'hire_date' => ['nullable', 'date'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'] ?? null,
        ]);

        $employeeRoleId = Role::where('slug', 'hotel-manager')->value('id');
        if ($employeeRoleId) {
            $user->roles()->attach($employeeRoleId);
        }

        Employee::create([
            'user_id' => $user->id,
            'hotel_id' => $validated['hotel_id'],
            'employee_code' => 'EMP-'.strtoupper(Str::random(8)),
            'position' => $validated['position'],
            'hire_date' => $validated['hire_date'],
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['user', 'hotel']);

        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $employee->load('user');
        $hotels = Hotel::where('is_active', true)->orderBy('name')->get();

        return view('admin.employees.edit', compact('employee', 'hotels'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'position' => ['nullable', 'string', 'max:255'],
            'hotel_id' => ['nullable', 'exists:hotels,id'],
            'hire_date' => ['nullable', 'date'],
            'is_active' => ['boolean'],
        ]);

        $employee->update($validated);

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->user()->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted.');
    }
}
