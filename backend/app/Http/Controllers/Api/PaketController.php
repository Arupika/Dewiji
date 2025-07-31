<?php

namespace App\Http\Controllers\Api;

use App\Models\Paket;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaketResource; // Pastikan ini diimport
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mengambil daftar paket. Bisa paginasi atau semua data berdasarkan request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Mengecek apakah ada parameter 'per_page' dengan nilai 'all'
        // Jika ada, ini menandakan permintaan untuk mengambil semua data tanpa paginasi.
        // Contoh URL: /api/pakets?per_page=all
        if ($request->has('per_page') && $request->per_page === 'all') {
            $pakets = Paket::orderBy('id', 'asc')->get(); // Ambil semua data
            // Mengembalikan koleksi paket dengan Resource.
            // Pastikan PaketResource Anda dapat menangani koleksi non-paginasi dengan benar.
            return new PaketResource(true, 'List Data Paket (Semua)', $pakets);
        }

        // Jika tidak ada parameter 'per_page=all', lakukan paginasi default.
        // Anda juga bisa memungkinkan jumlah item per halaman diatur dari frontend.
        // Contoh URL: /api/pakets?per_page=10 (akan menampilkan 10 item per halaman)
        $perPage = $request->input('per_page', 6); // Default 6 item per halaman
        $pakets = Paket::orderBy('id', 'asc')->paginate($perPage);

        return new PaketResource(true, 'List Data Paket', $pakets);
    }

    /**
     * Store a newly created resource in storage.
     * Menambahkan paket baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'           => 'required|string|max:255',
            'destinasi'      => 'nullable|array',
            'destinasi.*'    => 'nullable|string',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'harga'          => 'required|array',
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

        $gambarName = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = $gambar->hashName();
            $gambar->storeAs('pakets', $gambarName, 'public');
        }

        $paket = Paket::create([
            'nama'           => $request->nama,
            'destinasi'      => $request->destinasi,
            'gambar'         => $gambarName,
            'harga'          => $request->harga,
            'termasuk'       => $request->termasuk,
            'tidak_termasuk' => $request->tidak_termasuk,
            'deskripsi'      => $request->deskripsi,
        ]);

        return new PaketResource(true, 'Paket berhasil ditambahkan!', $paket);
    }

    /**
     * Display the specified resource.
     * Menampilkan detail satu paket.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paket = Paket::find($id);
        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return new PaketResource(true, 'Detail Data Paket!', $paket);
    }

    /**
     * Update the specified resource in storage.
     * Mengubah data paket yang ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $paket = Paket::find($id);
        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'           => 'required|string|max:255',
            'destinasi'      => 'nullable|array',
            'destinasi.*'    => 'nullable|string',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'harga'          => 'required|array',
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
            // Hapus gambar lama jika ada dan file-nya ada di storage
            if ($paket->gambar && Storage::exists('pakets/' . $paket->gambar)) {
                 Storage::delete('pakets/' . $paket->gambar);
            }
            $gambar = $request->file('gambar');
            $gambarName = $gambar->hashName();
            $gambar->storeAs('pakets', $gambarName, 'public');
            $paket->gambar = $gambarName; // Update nama file gambar di model
        }

        // Update field-field paket
        $paket->nama            = $request->nama;
        $paket->destinasi       = $request->destinasi;
        $paket->harga           = $request->harga;
        $paket->termasuk        = $request->termasuk;
        $paket->tidak_termasuk  = $request->tidak_termasuk;
        $paket->deskripsi       = $request->deskripsi;
        
        $paket->save();

        return new PaketResource(true, 'Paket berhasil diperbarui!', $paket);
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus paket.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paket = Paket::find($id);
        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus gambar paket dari storage jika ada dan file-nya ada
        if ($paket->gambar && Storage::exists('pakets/' . $paket->gambar)) {
            Storage::delete('pakets/' . $paket->gambar);
        }

        $paket->delete();
        return new PaketResource(true, 'Data Paket Berhasil Dihapus!', null);
    }
}