<?php
namespace App\Http\Controllers;

use App\Models\HolidayPackage;
use Illuminate\Http\Request;

class HolidayPackageController extends Controller
{
    public function index()
    {
        return HolidayPackage::all();
    }

    public function store(Request $request)
    {
        $package = HolidayPackage::create($request->all());
        return response()->json($package, 201);
    }

    public function show($id)
    {
        return HolidayPackage::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $package = HolidayPackage::findOrFail($id);
        $package->update($request->all());
        return response()->json($package);
    }

    public function destroy($id)
    {
        HolidayPackage::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
// This code defines a HolidayPackageController that manages holiday package records in a Laravel application.
// It includes methods to list all holiday packages, create a new holiday package, show a specific holiday package by ID, update an existing holiday package, and delete a holiday package by ID.