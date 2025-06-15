<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        return Destination::all();
    }

    public function store(Request $request)
    {
        $destination = Destination::create($request->all());
        return response()->json($destination, 201);
    }

    public function show($id)
    {
        return Destination::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);
        $destination->update($request->all());
        return response()->json($destination);
    }

    public function destroy($id)
    {
        Destination::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
