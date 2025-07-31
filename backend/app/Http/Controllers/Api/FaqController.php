<?php

namespace App\Http\Controllers\Api;

use App\Models\Faq;
use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource; // Pastikan ini diimport
use Illuminate\Http\Request; // PENTING: Import Request
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mengambil daftar FAQ. Bisa paginasi atau semua data berdasarkan request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) // PENTING: Tambahkan Request $request
    {
        // Mengecek apakah ada parameter 'per_page' dengan nilai 'all'
        // Jika ada, ini menandakan permintaan untuk mengambil semua data tanpa paginasi.
        // Contoh URL: /api/faqs?per_page=all
        if ($request->has('per_page') && $request->per_page === 'all') {
            $faqs = Faq::orderBy('id', 'asc')->get(); // Ambil semua data
            // Mengembalikan koleksi FAQ dengan Resource.
            // Pastikan FaqResource Anda dapat menangani koleksi non-paginasi dengan benar.
            return new FaqResource(true, 'List Data FAQ (Semua)', $faqs);
        }

        // Jika tidak ada parameter 'per_page=all', lakukan paginasi default.
        // Anda juga bisa memungkinkan jumlah item per halaman diatur dari frontend.
        // Contoh URL: /api/faqs?per_page=10 (akan menampilkan 10 item per halaman)
        $perPage = $request->input('per_page', 6); // Default 6 item per halaman
        $faqs = Faq::orderBy('id', 'asc')->paginate($perPage);

        return new FaqResource(true, 'List Data FAQ', $faqs);
    }

    /**
     * Store a newly created resource in storage.
     * Menambahkan FAQ baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required|string',
            'answer'   => 'required|string',
            'category' => 'required|string', // Atau 'array' jika disimpan sebagai JSON array
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $faq = Faq::create($request->all());

        return new FaqResource(true, 'FAQ berhasil ditambahkan!', $faq);
    }

    /**
     * Display the specified resource.
     * Menampilkan detail satu FAQ.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faq = Faq::find($id);
        if (!$faq) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return new FaqResource(true, 'Detail Data Faq!', $faq);
    }

    /**
     * Update the specified resource in storage.
     * Mengubah data FAQ yang ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required|string',
            'answer'   => 'required|string',
            'category' => 'required|string', // Atau 'array' jika disimpan sebagai JSON array
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $faq->update($request->all());

        return new FaqResource(true, 'FAQ berhasil diperbarui!', $faq);
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus FAQ.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = Faq::find($id);
        if (!$faq) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $faq->delete();
        return new FaqResource(true, 'Data FAQ Berhasil Dihapus!', null);
    }
}