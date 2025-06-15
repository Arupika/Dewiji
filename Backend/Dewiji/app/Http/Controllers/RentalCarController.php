<?php
namespace App\Http\Controllers;

use App\Models\RentalCar;
use Illuminate\Http\Request;

class RentalCarController extends Controller
{
    public function index()
    {
        return RentalCar::all();
    }

    public function store(Request $request)
    {
        $car = RentalCar::create($request->all());
        return response()->json($car, 201);
    }

    public function show($id)
    {
        return RentalCar::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $car = RentalCar::findOrFail($id);
        $car->update($request->all());
        return response()->json($car);
    }

    public function destroy($id)
    {
        RentalCar::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
// This code defines a RentalCarController that manages rental car records in a Laravel application.
// It includes methods to list all rental cars, create a new rental car, show a specific rental car by ID, update an existing rental car, and delete a rental car by ID.