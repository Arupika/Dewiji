<?php

namespace App\Http\Controllers\Api;

use App\Models\Faq;
use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('id', 'asc')->paginate(6);
        return new FaqResource(true, 'List Data FAQ', $faqs);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required|string',
            'answer'   => 'required|string',
            'category' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $faq = Faq::create($request->all());

        return new FaqResource(true, 'FAQ berhasil ditambahkan!', $faq);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        $faq = Faq::find($id);
        return new FaqResource(true, 'Detail Data Faq!', $faq);
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
            'title'    => 'required|string',
            'answer'   => 'required|string',
            'category' => 'required|string',
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
