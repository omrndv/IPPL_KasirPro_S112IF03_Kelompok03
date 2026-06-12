<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllAsArray();
        $user = auth()->user();
        $outlet = $user->outlet;

        return view('pengaturan', compact('settings', 'user', 'outlet'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil pengguna berhasil diperbarui.');
    }

    public function updateStore(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'store_phone' => ['required', 'string', 'max:30'],
            'store_address' => ['required', 'string', 'max:500'],
        ]);

        $outlet = $user->outlet;

        if (!$outlet) {
            return back()->with('error', 'Outlet untuk akun ini belum ditemukan.');
        }

        $outlet->update([
            'name' => $validated['store_name'],
            'phone' => $validated['store_phone'],
            'address' => $validated['store_address'],
        ]);

        return back()->with('success', 'Informasi toko berhasil diperbarui.');
    }

    public function updateReceipt(Request $request)
    {
        $validated = $request->validate([
            'tax_enabled' => ['nullable', 'boolean'],
            'tax_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'receipt_footer' => ['required', 'string', 'max:500'],
        ]);

        Setting::setValue('tax_enabled', $request->has('tax_enabled') ? '1' : '0');
        Setting::setValue('tax_rate', $validated['tax_rate']);
        Setting::setValue('receipt_footer', $validated['receipt_footer']);

        return back()->with('success', 'Pengaturan transaksi dan struk berhasil diperbarui.');
    }
}