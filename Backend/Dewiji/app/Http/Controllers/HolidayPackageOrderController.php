<?php

namespace App\Http\Controllers;

use App\Models\HolidayPackageOrder;
use Illuminate\Http\Request;

class HolidayPackageOrderController extends Controller
{
    // Tampilkan semua order
    public function index()
    {
        return HolidayPackageOrder::with(['user', 'package'])->orderBy('created_at', 'desc')->get();
    }

    // Tampilkan satu order by ID
    public function show($id)
    {
        $order = HolidayPackageOrder::with(['user', 'package'])->findOrFail($id);
        return response()->json($order);
    }

    // Buat order baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:holiday_packages,id',
            'car_type' => 'required|string|max:100',
            'tour_date' => 'required|date',
            'full_name' => 'required|string|max:150',
            'whatsapp_number' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $data['status'] = 'pending';

        $order = HolidayPackageOrder::create($data);

        return response()->json([
            'message' => 'Order berhasil dibuat.',
            'data' => $order
        ], 201);
    }

    // Update status atau info order
    public function update(Request $request, $id)
    {
        $order = HolidayPackageOrder::findOrFail($id);

        $data = $request->only(['status', 'notes']);
        $order->update($data);

        return response()->json([
            'message' => 'Order berhasil diupdate.',
            'data' => $order
        ]);
    }

    // Hapus order
    public function destroy($id)
    {
        $order = HolidayPackageOrder::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order berhasil dihapus.']);
    }

    // Endpoint khusus update status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $order = HolidayPackageOrder::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'message' => 'Status berhasil diubah.',
            'data' => $order
        ]);
    }
}
// This code defines a HolidayPackageOrderController that manages holiday package orders in a Laravel application.
// It includes methods to list all orders, show a specific order by ID, create a new order, update an existing order's status or information, and delete an order.  