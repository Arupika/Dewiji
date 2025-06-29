<?php

namespace App\Http\Controllers\Api;

use App\Models\User; // Pastikan model User diimport
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource; // Pastikan ini diimport jika kamu menggunakannya untuk respons
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // PENTING: Import Auth Facade
use Illuminate\Support\Facades\Hash; // PENTING: Import Hash Facade ini untuk Hash::make() atau bcrypt()

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\UserResource
     */
    public function index()
    {
        $users = User::orderBy('id', 'asc')->paginate(5);
        return new UserResource(true, 'List Data Users', $users);
    }

    /**
     * Store a newly created resource in storage. (Ini untuk Register)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\App\Http\Resources\UserResource
     */
    public function store(Request $request)
    {
        // 1. Validasi Input untuk Register:
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
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Mengembalikan error validasi
        }

        // 2. Penanganan Upload Gambar:
        $gambarName = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = $gambar->hashName(); // Mendapatkan nama file unik yang di-hash

            // PENTING: Menyimpan ke storage/app/public/users
            // Tambahkan 'public' sebagai disk kedua
            $gambar->storeAs('users', $gambarName, 'public'); 
        }

        // 3. Membuat User Baru di Database:
        // Password akan otomatis di-hash oleh `$casts` di model User jika 'password' => 'hashed'
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'birthDate'   => $request->birthDate,
            'role'        => $request->role ?? 'user', // Gunakan nilai dari request, default 'user' jika tidak ada
            'sex'         => $request->sex,
            'address'     => $request->address,
            'password'    => $request->password, // Cukup berikan plain password, model akan menghash
            'agreeTerms'  => $request->agreeTerms, // Menyimpan nilai boolean persetujuan terms
            'gambar'      => $gambarName, // Menyimpan nama file gambar (atau null jika tidak ada)
        ]);
        
        return new UserResource(true, 'User berhasil ditambahkan!', $user);
    }

    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // 1. Validasi Input untuk Login:
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        // 2. Mencoba Autentikasi User:
        // Auth::attempt() akan bekerja dengan password yang sudah di-hash di DB
        if (Auth::attempt($credentials)) {
             /** @var \App\Models\User $user */ // <-- TAMBAHKAN BARIS INI
            $user = Auth::user(); 
            
            // 3. Membuat Sanctum Token:
            $token = $user->createToken('auth_token')->plainTextToken;

            // 4. Mengembalikan Respon Berhasil Login:
            return response()->json([
                'message' => 'Login successful',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user, 
            ]);
        }

        // 5. Mengembalikan Respon Gagal Autentikasi:
        return response()->json(['message' => 'Unauthorized: Invalid credentials'], 401);
    }
    /**
     * Handle user logout (revoke token).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) // <-- NEW LOGOUT METHOD
    {
        // Memastikan request berasal dari user yang terautentikasi oleh Sanctum
        // dan memiliki currentAccessToken (yang ingin di-revoke)
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete(); // Revoke the current token
            return response()->json(['message' => 'Successfully logged out and token revoked'], 200);
        }

        return response()->json(['message' => 'No authenticated user found for logout'], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Resources\UserResource
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return new UserResource(true, 'Detail Data User!', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\App\Http\Resources\UserResource
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
            'password'    => 'nullable|string|min:6', // Password nullable saat update
            'agreeTerms'  => 'required|boolean',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Penanganan update gambar
        if ($request->hasFile('gambar')) {
            if ($user->gambar) {
                // Hapus gambar lama menggunakan path lengkap dari accessor jika diperlukan
                // atau hanya nama file jika kamu selalu menyimpan nama file saja di DB
                Storage::delete('users/' . basename($user->gambar)); 
            }
            $gambar = $request->file('gambar');
            $gambarName = $gambar->hashName();
            $gambar->storeAs('users', $gambarName, 'public'); // Simpan ke public disk
            $user->gambar = $gambarName; // Simpan nama file saja di DB
        }

        // Update field-field user
        $user->name       = $request->name;
        $user->email      = $request->email;
        $user->phone      = $request->phone;
        $user->birthDate  = $request->birthDate;
        $user->role       = $request->role ?? 'user';
        $user->sex        = $request->sex;
        $user->address    = $request->address;
        $user->agreeTerms = $request->agreeTerms;

        // Update password hanya jika diisi (Model akan menghash karena casts)
        if ($request->filled('password')) {
            $user->password = $request->password; // Cukup berikan plain password, model akan menghash
        }

        $user->save();

        return new UserResource(true, 'User berhasil diperbarui!', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\App\Http\Resources\UserResource
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus gambar profil jika ada
        if ($user->gambar) {
            // Gunakan basename() jika di DB hanya tersimpan nama file
            Storage::delete('users/' . basename($user->gambar)); 
        }

        $user->delete();

        return new UserResource(true, 'Data User Berhasil Dihapus!', null);
    }
}