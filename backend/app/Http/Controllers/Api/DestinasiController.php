<?php

namespace App\Http\Controllers\Api;

use App\Models\Destinasi;
use App\Http\Controllers\Controller;
use App\Http\Resources\DestinasiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        'harga'          => 'required|array', // SEKARANG array, bukan string JSON
        'jamOperasional' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Upload gambar ke storage
    $gambar = $request->file('gambar');
    $gambar->storeAs('destinasis', $gambar->hashName());

    // Simpan ke database
    $destinasi = Destinasi::create([
        'nama'            => $request->nama,
        'deskripsi'       => $request->deskripsi,
        'gambar'          => $gambar->hashName(),
        'location'        => $request->location,
        'kategori'        => $request->kategori,
        'harga'           => $request->harga, // langsung ambil array dari form
        'jamOperasional'  => $request->jamOperasional,
    ]);

    return new DestinasiResource(true, 'Destinasi berhasil ditambahkan!', $destinasi);
    }
}


