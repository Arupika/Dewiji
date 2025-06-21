<?php

namespace App\Http\Controllers\Api;

use App\Models\Destinasi;
use App\Http\Controllers\Controller;
use App\Http\Resources\DestinasiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DestinasiController extends Controller
{
    public function index()
    {
        $destinasis = Destinasi::latest()->paginate(5);
        return new DestinasiResource(true, 'List Data Destinasi', $destinasis);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'           => 'required|string',
            'deskripsi'      => 'required|string',
            'gambar'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location'       => 'required|string',
            'kategori'       => 'required|array',
            'harga'          => 'required|array',
            'jamOperasional' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $gambar = $request->file('gambar');
        $gambar->storeAs('destinasis', $gambar->hashName());

        $destinasi = Destinasi::create([
            'nama'            => $request->nama,
            'deskripsi'       => $request->deskripsi,
            'gambar'          => $gambar->hashName(),
            'location'        => $request->location,
            'kategori'        => $request->kategori,
            'harga'           => $request->harga,
            'jamOperasional'  => $request->jamOperasional,
        ]);

        return new DestinasiResource(true, 'Destinasi berhasil ditambahkan!', $destinasi);
    }

    public function show($id)
    {
        $destinasi = Destinasi::find($id);
        return new DestinasiResource(true, 'Detail Data Destinasi!', $destinasi);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama'           => 'required|string',
            'deskripsi'      => 'required|string',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            Storage::delete('destinasis/' . basename($destinasi->gambar));

            // Upload gambar baru
            $gambar = $request->file('gambar');
            $gambar->storeAs('destinasis', $gambar->hashName());

            // Update dengan gambar baru
            $destinasi->update([
                'nama'           => $request->nama,
                'deskripsi'      => $request->deskripsi,
                'gambar'         => $gambar->hashName(),
                'location'       => $request->location,
                'kategori'       => $request->kategori,
                'harga'          => $request->harga,
                'jamOperasional' => $request->jamOperasional,
            ]);
        } else {
            // Update tanpa gambar baru
            $destinasi->update([
                'nama'           => $request->nama,
                'deskripsi'      => $request->deskripsi,
                'location'       => $request->location,
                'kategori'       => $request->kategori,
                'harga'          => $request->harga,
                'jamOperasional' => $request->jamOperasional,
            ]);
        }

        return new DestinasiResource(true, 'Data Destinasi Berhasil Diubah!', $destinasi);
    }
    public function destroy($id)
    {
        $destinasi = Destinasi::find($id);
        if (!$destinasi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus gambar dari storage
        Storage::delete('destinasis/' . basename($destinasi->gambar));

        $destinasi->delete();
        return new DestinasiResource(true, 'Data Destinasi Berhasil Dihapus!', null);
    }
}
