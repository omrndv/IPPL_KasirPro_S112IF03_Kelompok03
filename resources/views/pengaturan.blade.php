@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan Sistem</h1>
        <p class="text-gray-500 text-sm mt-1">Sesuaikan profil toko, struk, dan preferensi akun Anda di sini.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Profil Pengguna</h3>
                <div class="flex flex-col items-center mb-4">
                    <div
                        class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl font-bold mb-3">
                        AD
                    </div>
                    <h4 class="text-lg font-bold text-gray-900">Admin KasirPro</h4>
                    <p class="text-sm text-gray-500">admin@kasirpro.com</p>
                    <span
                        class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mt-2">Administrator
                        Utama</span>
                </div>

                <form action="#" method="POST" class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nama Tampilan</label>
                        <input type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="Admin KasirPro">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Password Baru</label>
                        <input type="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="••••••••">
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition">Perbarui
                        Profil</button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Informasi Toko</h3>
                <form action="#" method="POST">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nama Toko</label>
                            <input type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                value="KasirPro Coffee & Eatery">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nomor Telepon / WA</label>
                            <input type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                value="0812-3456-7890">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Alamat Lengkap (Ditampilkan di
                                Struk)</label>
                            <textarea rows="3"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">Jl. DI Panjaitan No. 128, Purwokerto Selatan, Kab. Banyumas</textarea>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 transition">Simpan
                            Informasi Toko</button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Pengaturan Transaksi & Struk</h3>

                <div class="space-y-4 mb-6">
                    <label class="inline-flex items-center cursor-pointer justify-between w-full">
                        <div>
                            <span class="block text-sm font-medium text-gray-900">Terapkan Pajak (PPN)</span>
                            <span class="block text-xs text-gray-500">Otomatis tambahkan pajak pada setiap transaksi.</span>
                        </div>
                        <input type="checkbox" value="" class="sr-only peer" checked>
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                        </div>
                    </label>

                    <div class="w-1/3">
                        <label class="block mb-2 text-xs font-medium text-gray-900">Besaran Pajak (%)</label>
                        <input type="number"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                            value="10">
                    </div>
                </div>

                <hr class="border-gray-100 my-4">

                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-900">Pesan Footer Struk (Catatan Bawah)</label>
                    <textarea rows="2"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">Terima kasih telah berkunjung!&#10;Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</textarea>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="button"
                        class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 transition">Simpan
                        Pengaturan Struk</button>
                </div>
            </div>

        </div>
    </div>
@endsection
