<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(5);
        return new UserResource(true, 'List Data Users', $users);
    }
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'        => 'required|string|max:255',
        'email'       => 'required|email|unique:users,email',
        'phone'       => 'nullable|string|max:20',
        'birthDate'   => 'nullable|date',
        'role'        => 'nullable|string|in:user,admin',
        'sex'         => 'nullable|in:male,female',
        'address'     => 'nullable|string',
        'password'    => 'required|string|min:6',
        'agreeTerms'  => 'required|boolean',
        'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $gambarName = null;
    if ($request->hasFile('gambar')) {
        $gambar = $request->file('gambar');
        $gambarName = $gambar->hashName();
        $gambar->storeAs('users', $gambarName);
    }

    $user = User::create([
        'name'        => $request->name,
        'email'       => $request->email,
        'phone'       => $request->phone,
        'birthDate'   => $request->birthDate,
        'role'        => $request->role ?? 'user',
        'sex'         => $request->sex,
        'address'     => $request->address,
        'password'    => bcrypt($request->password),
        'agreeTerms'  => $request->agreeTerms,
        'gambar'      => $gambarName,
    ]);

    return new UserResource(true, 'User berhasil ditambahkan!', $user);
}


}


