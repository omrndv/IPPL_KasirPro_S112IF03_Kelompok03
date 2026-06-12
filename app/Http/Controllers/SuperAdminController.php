<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    public function index(Request $request)
    {
        // Stats
        $totalUsers = User::count();
        $totalOutlets = Outlet::count();
        
        $roleCounts = User::select('role', \DB::raw('count(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();
            
        $ownersCount = $roleCounts['owner'] ?? 0;
        $adminsCount = $roleCounts['admin'] ?? 0;
        $cashiersCount = $roleCounts['cashier'] ?? 0;
        $superadminsCount = $roleCounts['superadmin'] ?? 0;

        // User Query with Search and Filter
        $userQuery = User::with('outlet')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $userQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $userQuery->where('role', $request->role);
        }

        if ($request->filled('outlet_id')) {
            $userQuery->where('outlet_id', $request->outlet_id);
        }

        $users = $userQuery->paginate(10)->withQueryString();

        // Get all outlets for dropdown and listing
        $outlets = Outlet::latest()->get();

        return view('superadmin.dashboard', compact(
            'totalUsers',
            'totalOutlets',
            'ownersCount',
            'adminsCount',
            'cashiersCount',
            'superadminsCount',
            'users',
            'outlets'
        ));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['superadmin', 'owner', 'admin', 'cashier'])],
            'outlet_id' => [
                Rule::requiredIf(fn () => $request->role !== 'superadmin'),
                'nullable',
                'exists:outlets,id'
            ],
        ], [
            'outlet_id.required_if' => 'Outlet wajib diisi untuk pengguna selain Super Admin.',
            'username.unique' => 'Username ini sudah digunakan.',
            'email.unique' => 'Email ini sudah digunakan.',
            'password.min' => 'Password minimal harus 8 karakter.',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'outlet_id' => $request->role === 'superadmin' ? null : $request->outlet_id,
        ]);

        return redirect()->back()->with('success', 'Akun pengguna berhasil dibuat!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => ['required', Rule::in(['superadmin', 'owner', 'admin', 'cashier'])],
            'outlet_id' => [
                Rule::requiredIf(fn () => $request->role !== 'superadmin'),
                'nullable',
                'exists:outlets,id'
            ],
        ], [
            'outlet_id.required_if' => 'Outlet wajib diisi untuk pengguna selain Super Admin.',
            'username.unique' => 'Username ini sudah digunakan.',
            'email.unique' => 'Email ini sudah digunakan.',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'outlet_id' => $request->role === 'superadmin' ? null : $request->outlet_id,
        ]);

        return redirect()->back()->with('success', 'Data akun pengguna berhasil diperbarui!');
    }

    public function resetUserPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'password' => 'required|string|min:8',
        ], [
            'password.min' => 'Password minimal harus 8 karakter.',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password pengguna berhasil direset!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Akun pengguna berhasil dihapus.');
    }

    public function storeOutlet(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        Outlet::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Outlet baru berhasil ditambahkan!');
    }

    public function updateOutlet(Request $request, $id)
    {
        $outlet = Outlet::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $outlet->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Outlet berhasil diperbarui!');
    }

    public function destroyOutlet($id)
    {
        $outlet = Outlet::findOrFail($id);

        // Check if there are users connected to this outlet
        $connectedUsers = User::where('outlet_id', $outlet->id)->count();
        if ($connectedUsers > 0) {
            return redirect()->back()->with('error', 'Gagal menghapus outlet. Masih terdapat ' . $connectedUsers . ' pengguna yang terhubung ke outlet ini.');
        }

        $outlet->delete();

        return redirect()->back()->with('success', 'Outlet berhasil dihapus.');
    }
}
