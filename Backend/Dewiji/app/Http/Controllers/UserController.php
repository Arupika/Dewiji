<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            ...$request->except('password'),
            'password' => Hash::make($request->password)
        ]);

        return response()->json($user, 201);
    }

    public function show($id) {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->update($request->except('password'));

        return response()->json($user);
    }

    public function destroy($id) {
        User::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
// This code defines a UserController that manages user records in a Laravel application.
// It includes methods to list all users, create a new user, show a specific user by ID, update an existing user, and delete a user by ID.