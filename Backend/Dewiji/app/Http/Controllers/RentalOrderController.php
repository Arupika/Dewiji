<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RentalOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
    return RentalOrder::with(['user', 'car'])->get();
}

public function store(Request $request) {
    $data = $request->validate([
        'user_id' => 'required|exists:users,id',
        'car_id' => 'required|exists:rental_cars,id',
        'pickup_location' => 'required',
        'pickup_date' => 'required|date',
        'duration_days' => 'required|integer',
        'whatsapp_number' => 'required',
    ]);

    $data['status'] = 'pending';
    $order = RentalOrder::create($data);

    return response()->json($order, 201);
}

public function updateStatus($id, Request $request) {
    $order = RentalOrder::findOrFail($id);
    $order->status = $request->status ?? 'pending';
    $order->save();

    return response()->json($order);
}

}
