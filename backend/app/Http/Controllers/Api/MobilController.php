<?php

namespace App\Http\Controllers\Api;

use App\Models\Mobil;
use App\Http\Controllers\Controller;
use App\Http\Resources\MobilResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::orderBy('id', 'asc')->paginate(5);
        return new MobilResource(true, 'List Data Mobil', $mobils);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'        => 'required|string',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric',
            'harga12jam'  => 'required|numeric',
            'kapasitas'   => 'required|integer',
            'fitur'       => 'required|array',
            'termasuk'    => 'required|array',
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
            'fitur'       => $request->fitur,
            'termasuk'    => $request->termasuk,
            'gambar'      => $gambar->hashName(),
        ]);

        return new MobilResource(true, 'Mobil berhasil ditambahkan!', $mobil);
    }

    public function show($id)
    {
        $mobil = Mobil::find($id);
        return new MobilResource(true, 'Detail Data Mobil!', $mobil);
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
            'nama'        => 'required|string',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric',
            'harga12jam'  => 'required|numeric',
            'kapasitas'   => 'required|integer',
            'fitur'       => 'required|array',
            'termasuk'    => 'required|array',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mobil = Mobil::find($id);
        if (!$mobil) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        if ($request->hasFile('gambar')) {
            Storage::delete('mobils/' . basename($mobil->gambar));

            $gambar = $request->file('gambar');
            $gambar->storeAs('mobils', $gambar->hashName());

            $mobil->update([
                'nama'        => $request->nama,
                'deskripsi'   => $request->deskripsi,
                'harga'       => $request->harga,
                'harga12jam'  => $request->harga12jam,
                'kapasitas'   => $request->kapasitas,
                'fitur'       => $request->fitur,
                'termasuk'    => $request->termasuk,
                'gambar'      => $gambar->hashName(),
            ]);
        } else {
            $mobil->update([
                'nama'        => $request->nama,
                'deskripsi'   => $request->deskripsi,
                'harga'       => $request->harga,
                'harga12jam'  => $request->harga12jam,
                'kapasitas'   => $request->kapasitas,
                'fitur'       => $request->fitur,
                'termasuk'    => $request->termasuk,
            ]);
        }

        return new MobilResource(true, 'Mobil berhasil diperbarui!', $mobil);
    }
    public function destroy($id)
    {
        $mobil = Mobil::find($id);
        if (!$mobil) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        Storage::delete('mobils/' . basename($mobil->gambar));
        $mobil->delete();

        return new MobilResource(true, 'Data Mobil Berhasil Dihapus!', null);
    }
}
