<?php

namespace App\Http\Controllers\Api;

use App\Models\Paket;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaketResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::orderBy('id', 'asc')->paginate(5);
        return new PaketResource(true, 'List Data Paket', $pakets);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destinasi'        => 'required|array',
            'gambar.*'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'harga'            => 'required|array',
            'termasuk'         => 'required|array',
            'tidak_termasuk'   => 'required|array',
            'deskripsi'        => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $gambarPaths = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $gambar) {
                $gambar->storeAs('pakets', $gambar->hashName());
                $gambarPaths[] = $gambar->hashName();
            }
        }

        $paket = Paket::create([
            'destinasi'       => $request->destinasi,
            'gambar'          => $gambarPaths,
            'harga'           => $request->harga,
            'termasuk'        => $request->termasuk,
            'tidak_termasuk'  => $request->tidak_termasuk,
            'deskripsi'       => $request->deskripsi,
        ]);

        return new PaketResource(true, 'Paket berhasil ditambahkan!', $paket);
    }

    public function show($id)
    {
        $paket = Paket::find($id);
        return new PaketResource(true, 'Detail Data Paket!', $paket);
    }

    /**
     * update
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'destinasi'        => 'required|array',
            'gambar.*'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'harga'            => 'required|array',
            'termasuk'         => 'required|array',
            'tidak_termasuk'   => 'required|array',
            'deskripsi'        => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $paket = Paket::find($id);
        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $gambarPaths = $paket->gambar ?? [];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if (is_array($gambarPaths)) {
                foreach ($gambarPaths as $old) {
                    Storage::delete('pakets/' . $old);
                }
            }

            // Simpan gambar baru
            $gambarPaths = [];
            foreach ($request->file('gambar') as $gambar) {
                $gambar->storeAs('pakets', $gambar->hashName());
                $gambarPaths[] = $gambar->hashName();
            }
        }

        $paket->update([
            'destinasi'       => $request->destinasi,
            'gambar'          => $gambarPaths,
            'harga'           => $request->harga,
            'termasuk'        => $request->termasuk,
            'tidak_termasuk'  => $request->tidak_termasuk,
            'deskripsi'       => $request->deskripsi,
        ]);

        return new PaketResource(true, 'Paket berhasil diperbarui!', $paket);
    }
    public function destroy($id)
    {
        $paket = Paket::find($id);
        if (!$paket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus gambar dari storage
        if (is_array($paket->gambar)) {
            foreach ($paket->gambar as $gambar) {
                Storage::delete('pakets/' . $gambar);
            }
        }

        $paket->delete();
        return new PaketResource(true, 'Data Paket Berhasil Dihapus!', null);
    }
}
