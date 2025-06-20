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
        $faqs = Faq::latest()->paginate(5);
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

}


