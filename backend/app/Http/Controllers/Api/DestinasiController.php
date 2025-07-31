<?php

namespace App\Http\Controllers\Api;

use App\Models\Destinasi;
use App\Http\Controllers\Controller;
use App\Http\Resources\DestinasiResource; // Asumsi Anda menggunakan Resource ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DestinasiController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mengambil daftar destinasi. Bisa paginasi atau semua data berdasarkan request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Mengecek apakah ada parameter 'per_page' dengan nilai 'all'
        // Jika ada, ini menandakan permintaan untuk mengambil semua data tanpa paginasi.
        // Contoh URL: /api/destinasis?per_page=all
        if ($request->has('per_page') && $request->per_page === 'all') {
            $destinasis = Destinasi::orderBy('id', 'asc')->get(); // Ambil semua data
            // Mengembalikan koleksi destinasi dengan Resource.
            // Pastikan DestinasiResource Anda dapat menangani koleksi non-paginasi.
            // Jika DestinasiResource Anda hanya membungkus data paginasi, Anda mungkin perlu
            // membuat DestinasiCollection terpisah atau mengembalikan array biasa.
            return new DestinasiResource(true, 'List Data Destinasi (Semua)', $destinasis);
        }

        // Jika tidak ada parameter 'per_page=all', lakukan paginasi default.
        // Anda juga bisa memungkinkan jumlah item per halaman diatur dari frontend.
        // Contoh URL: /api/destinasis?per_page=10 (akan menampilkan 10 item per halaman)
        $perPage = $request->input('per_page', 6); // Default 6 item per halaman
        $destinasis = Destinasi::orderBy('id', 'asc')->paginate($perPage);

        return new DestinasiResource(true, 'List Data Destinasi', $destinasis);
    }

    /**
     * Store a newly created resource in storage.
     * Menambahkan destinasi baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'           => 'required|string',
            'deskripsi'      => 'required|string',
            'gambar'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location'       => 'required|string',
            'kategori'       => 'required|array', // Pastikan ini disimpan sebagai JSON di DB
            'harga'          => 'required|array',   // Pastikan ini disimpan sebagai JSON di DB
            'jamOperasional' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $gambar = $request->file('gambar');
        $gambar->storeAs('destinasis', $gambar->hashName()); // Simpan gambar di storage

        $destinasi = Destinasi::create([
            'nama'            => $request->nama,
            'deskripsi'       => $request->deskripsi,
            'gambar'          => $gambar->hashName(),
            'location'        => $request->location,
            'kategori'        => $request->kategori, // Laravel akan otomatis meng-cast ke JSON jika kolomnya jsonb/json
            'harga'           => $request->harga,    // Laravel akan otomatis meng-cast ke JSON jika kolomnya jsonb/json
            'jamOperasional'  => $request->jamOperasional,
        ]);

        return new DestinasiResource(true, 'Destinasi berhasil ditambahkan!', $destinasi);
    }

    /**
     * Display the specified resource.
     * Menampilkan detail satu destinasi.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $destinasi = Destinasi::find($id);

        if (!$destinasi) {
            return response()->json(['message' => 'Destinasi tidak ditemukan'], 404);
        }

        return new DestinasiResource(true, 'Detail Data Destinasi!', $destinasi);
    }

    /**
     * Update the specified resource in storage.
     * Mengubah data destinasi yang ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama'           => 'required|string',
            'deskripsi'      => 'required|string',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Nullable karena bisa tidak diupdate
            'location'       => 'required|string',
            'kategori'       => 'required|array',
            'harga'          => 'required|array',
            'jamOperasional' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $destinasi = Destinasi::find($id);

        if (!$destinasi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Handle update gambar jika ada file baru diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            if ($destinasi->gambar && Storage::exists('destinasis/' . basename($destinasi->gambar))) {
                Storage::delete('destinasis/' . basename($destinasi->gambar));
            }

            // Upload gambar baru
            $gambar = $request->file('gambar');
            $gambar->storeAs('destinasis', $gambar->hashName());
            $gambarFileName = $gambar->hashName();
        } else {
            // Jika tidak ada gambar baru, gunakan gambar yang sudah ada
            $gambarFileName = basename($destinasi->gambar);
        }

        // Update data destinasi
        $destinasi->update([
            'nama'           => $request->nama,
            'deskripsi'      => $request->deskripsi,
            'gambar'         => $gambarFileName, // Gunakan nama file gambar yang sudah ditentukan
            'location'       => $request->location,
            'kategori'       => $request->kategori,
            'harga'          => $request->harga,
            'jamOperasional' => $request->jamOperasional,
        ]);

        return new DestinasiResource(true, 'Data Destinasi Berhasil Diubah!', $destinasi);
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus destinasi.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destinasi = Destinasi::find($id);
        if (!$destinasi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus gambar dari storage sebelum menghapus record dari database
        if ($destinasi->gambar && Storage::exists('destinasis/' . basename($destinasi->gambar))) {
            Storage::delete('destinasis/' . basename($destinasi->gambar));
        }

        $destinasi->delete();
        return new DestinasiResource(true, 'Data Destinasi Berhasil Dihapus!', null);
    }
}