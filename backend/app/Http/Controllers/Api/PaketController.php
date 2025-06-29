<?php

namespace App\Http\Controllers\Api;

use App\Models\Paket; // Pastikan model Paket diimport
use App\Http\Controllers\Controller;
use App\Http\Resources\PaketResource; // Pastikan ini diimport (atau sesuaikan jika nama resource berbeda)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // PENTING: Import Storage Facade untuk upload gambar

class PaketController extends Controller
{
    public function index()
    {
        // Sesuaikan jika ada filter atau pagination seperti di FAQ
        $pakets = Paket::orderBy('id', 'asc')->paginate(6); // Contoh pagination
        return new PaketResource(true, 'List Data Paket', $pakets);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'           => 'required|string|max:255', // <-- BARU: Validasi nama
            'destinasi'      => 'nullable|array', // Harus array dari frontend
            'destinasi.*'    => 'nullable|string', // Setiap item destinasi harus string
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'harga'          => 'required|array', // <-- HARGA: Sekarang diharapkan array dari objek harga
            'harga.*.tipe'   => 'required|string', // Contoh: Dewasa, Anak-anak, Mobil
            'harga.*.lama'   => 'nullable|string', // Harga lama (string, misal "Rp 2.000.000")
            'harga.*.diskon' => 'required|string', // Harga diskon (string, misal "Rp 1.500.000")
            'termasuk'       => 'nullable|array',
            'termasuk.*'     => 'nullable|string',
            'tidak_termasuk' => 'nullable|array',
            'tidak_termasuk.*' => 'nullable|string',
            'deskripsi'      => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Penanganan upload gambar
        $gambarName = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = $gambar->hashName();
            // Menyimpan ke storage/app/public/pakets
            $gambar->storeAs('pakets', $gambarName, 'public'); 
        }

        // Buat paket baru
        $paket = Paket::create([
            'nama'           => $request->nama, // <-- BARU: Simpan nama
            'destinasi'      => $request->destinasi,
            'gambar'         => $gambarName, // Simpan nama file gambar
            'harga'          => $request->harga, // Laravel akan otomatis mengonversi array ke JSON
            'termasuk'       => $request->termasuk,
            'tidak_termasuk' => $request->tidak_termasuk,
            'deskripsi'      => $request->deskripsi,
        ]);

        return new PaketResource(true, 'Paket berhasil ditambahkan!', $paket);
    }

    public function show($id)
    {
        $paket = Paket::find($id);
        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return new PaketResource(true, 'Detail Data Paket!', $paket);
    }

    public function update(Request $request, $id)
    {
        $paket = Paket::find($id);
        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'           => 'required|string|max:255', // <-- BARU: Validasi nama
            'destinasi'      => 'nullable|array',
            'destinasi.*'    => 'nullable|string',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'harga'          => 'required|array', // <-- HARGA: Diharapkan array dari objek harga
            'harga.*.tipe'   => 'required|string',
            'harga.*.lama'   => 'nullable|string',
            'harga.*.diskon' => 'required|string',
            'termasuk'       => 'nullable|array',
            'termasuk.*'     => 'nullable|string',
            'tidak_termasuk' => 'nullable|array',
            'tidak_termasuk.*' => 'nullable|string',
            'deskripsi'      => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Penanganan update gambar
        if ($request->hasFile('gambar')) {
            if ($paket->gambar) { // $paket->gambar akan mengembalikan URL lengkap, jadi perlu basename
                Storage::delete('pakets/' . basename($paket->gambar)); 
            }
            $gambar = $request->file('gambar');
            $gambarName = $gambar->hashName();
            $gambar->storeAs('pakets', $gambarName, 'public'); 
            $paket->gambar = $gambarName; 
        }

        // Update field-field paket
        $paket->nama           = $request->nama; // <-- BARU: Update nama
        $paket->destinasi      = $request->destinasi;
        $paket->harga          = $request->harga;
        $paket->termasuk       = $request->termasuk;
        $paket->tidak_termasuk = $request->tidak_termasuk;
        $paket->deskripsi      = $request->deskripsi;
        
        $paket->save();

        return new PaketResource(true, 'Paket berhasil diperbarui!', $paket);
    }

    public function destroy($id)
    {
        $paket = Paket::find($id);
        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus gambar paket jika ada
        if ($paket->gambar) {
            Storage::delete('pakets/' . basename($paket->gambar)); 
        }

        $paket->delete();
        return new PaketResource(true, 'Data Paket Berhasil Dihapus!', null);
    }
}