<?php

namespace App\Http\Controllers\Api;

use App\Models\Mobil;
use App\Http\Controllers\Controller;
use App\Http\Resources\MobilResource; // Asumsi Anda menggunakan Resource ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mengambil daftar mobil. Bisa paginasi atau semua data berdasarkan request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Mengecek apakah ada parameter 'per_page' dengan nilai 'all'
        // Jika ada, ini menandakan permintaan untuk mengambil semua data tanpa paginasi.
        // Contoh URL: /api/mobils?per_page=all
        if ($request->has('per_page') && $request->per_page === 'all') {
            $mobils = Mobil::orderBy('id', 'asc')->get(); // Ambil semua data
            // Mengembalikan koleksi mobil dengan Resource.
            // Pastikan MobilResource Anda dapat menangani koleksi non-paginasi.
            return new MobilResource(true, 'List Data Mobil (Semua)', $mobils);
        }

        // Jika tidak ada parameter 'per_page=all', lakukan paginasi default.
        // Anda juga bisa memungkinkan jumlah item per halaman diatur dari frontend.
        // Contoh URL: /api/mobils?per_page=10 (akan menampilkan 10 item per halaman)
        $perPage = $request->input('per_page', 6); // Default 6 item per halaman
        $mobils = Mobil::orderBy('id', 'asc')->paginate($perPage);

        return new MobilResource(true, 'List Data Mobil', $mobils);
    }

    /**
     * Store a newly created resource in storage.
     * Menambahkan mobil baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'        => 'required|string',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric',
            'harga12jam'  => 'required|numeric',
            'kapasitas'   => 'required|integer',
            'fitur'       => 'required|array', // Pastikan ini disimpan sebagai JSON di DB
            'termasuk'    => 'required|array', // Pastikan ini disimpan sebagai JSON di DB
            'gambar'      => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $gambar = $request->file('gambar');
        $gambar->storeAs('mobils', $gambar->hashName());

        $mobil = Mobil::create([
            'nama'        => $request->nama,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'harga12jam'  => $request->harga12jam,
            'kapasitas'   => $request->kapasitas,
            'fitur'       => $request->fitur,    // Laravel akan otomatis meng-cast ke JSON jika kolomnya jsonb/json
            'termasuk'    => $request->termasuk, // Laravel akan otomatis meng-cast ke JSON jika kolomnya jsonb/json
            'gambar'      => $gambar->hashName(),
        ]);

        return new MobilResource(true, 'Mobil berhasil ditambahkan!', $mobil);
    }

    /**
     * Display the specified resource.
     * Menampilkan detail satu mobil.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mobil = Mobil::find($id);

        if (!$mobil) {
            return response()->json(['message' => 'Mobil tidak ditemukan'], 404);
        }

        return new MobilResource(true, 'Detail Data Mobil!', $mobil);
    }

    /**
     * Update the specified resource in storage.
     * Mengubah data mobil yang ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama'        => 'required|string',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric',
            'harga12jam'  => 'required|numeric',
            'kapasitas'   => 'required|integer',
            'fitur'       => 'required|array',
            'termasuk'    => 'required|array',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Nullable karena bisa tidak diupdate
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mobil = Mobil::find($id);
        if (!$mobil) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Handle update gambar jika ada file baru diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage jika ada
            if ($mobil->gambar && Storage::exists('mobils/' . basename($mobil->gambar))) {
                Storage::delete('mobils/' . basename($mobil->gambar));
            }

            // Upload gambar baru
            $gambar = $request->file('gambar');
            $gambar->storeAs('mobils', $gambar->hashName());
            $gambarFileName = $gambar->hashName();
        } else {
            // Jika tidak ada gambar baru, gunakan gambar yang sudah ada
            $gambarFileName = basename($mobil->gambar);
        }

        // Update data mobil
        $mobil->update([
            'nama'        => $request->nama,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'harga12jam'  => $request->harga12jam,
            'kapasitas'   => $request->kapasitas,
            'fitur'       => $request->fitur,
            'termasuk'    => $request->termasuk,
            'gambar'      => $gambarFileName, // Gunakan nama file gambar yang sudah ditentukan
        ]);

        return new MobilResource(true, 'Mobil berhasil diperbarui!', $mobil);
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus mobil.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mobil = Mobil::find($id);
        if (!$mobil) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus gambar dari storage sebelum menghapus record dari database
        if ($mobil->gambar && Storage::exists('mobils/' . basename($mobil->gambar))) {
            Storage::delete('mobils/' . basename($mobil->gambar));
        }

        $mobil->delete();

        return new MobilResource(true, 'Data Mobil Berhasil Dihapus!', null);
    }
}