<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'asc')->paginate(5);
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

    public function show($id)
    {
        $user = User::find($id);
        return new UserResource(true, 'Detail Data User!', $user);
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
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $id,
            'phone'       => 'nullable|string|max:20',
            'birthDate'   => 'nullable|date',
            'role'        => 'nullable|string|in:user,admin',
            'sex'         => 'nullable|in:male,female',
            'address'     => 'nullable|string',
            'password'    => 'nullable|string|min:6',
            'agreeTerms'  => 'required|boolean',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('gambar')) {
            Storage::delete('users/' . basename($user->gambar));
            $gambar = $request->file('gambar');
            $gambarName = $gambar->hashName();
            $gambar->storeAs('users', $gambarName);
            $user->gambar = $gambarName;
        }

        $user->name       = $request->name;
        $user->email      = $request->email;
        $user->phone      = $request->phone;
        $user->birthDate  = $request->birthDate;
        $user->role       = $request->role ?? 'user';
        $user->sex        = $request->sex;
        $user->address    = $request->address;
        $user->agreeTerms = $request->agreeTerms;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return new UserResource(true, 'User berhasil diperbarui!', $user);
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        if ($user->gambar) {
            Storage::delete('users/' . basename($user->gambar));
        }

        $user->delete();

        return new UserResource(true, 'Data User Berhasil Dihapus!', null);
    }
}
