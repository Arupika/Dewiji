<?php

namespace App\Http\Controllers\Api;

use App\Models\Mobil;
use App\Http\Controllers\Controller;
use App\Http\Resources\MobilResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::latest()->paginate(5);
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

    // Simpan gambar ke storage/app/public/mobils
    $gambar = $request->file('gambar');
    $gambar->storeAs('mobils', $gambar->hashName());

    // Simpan ke database
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
}


