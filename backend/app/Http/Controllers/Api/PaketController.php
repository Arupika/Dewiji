<?php

namespace App\Http\Controllers\Api;

use App\Models\Paket;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaketResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::latest()->paginate(5);
        return new PaketResource(true, 'List Data Paket', $pakets);
    }
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'destinasi'        => 'required|array',
        'gambar.*'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'harga'            => 'required|array', // sekarang array, bukan string JSON
        'termasuk'         => 'required|array',
        'tidak_termasuk'   => 'required|array',
        'deskripsi'        => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Simpan gambar-gambar
    $gambarPaths = [];
    if ($request->hasFile('gambar')) {
        foreach ($request->file('gambar') as $gambar) {
            $gambar->storeAs('pakets', $gambar->hashName());
            $gambarPaths[] = $gambar->hashName();
        }
    }

    // Simpan ke database
    $paket = Paket::create([
        'destinasi'       => $request->destinasi,
        'gambar'          => $gambarPaths,
        'harga'           => $request->harga, // langsung array
        'termasuk'        => $request->termasuk,
        'tidak_termasuk'  => $request->tidak_termasuk,
        'deskripsi'       => $request->deskripsi,
    ]);

    return new PaketResource(true, 'Paket berhasil ditambahkan!', $paket);
    }
}
