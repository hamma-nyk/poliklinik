<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        // $users = User::with('permissions')->whereDoesntHave('roles', function($q){
        //     $q->where('name', 'superadmin'); // Sembunyikan superadmin agar tidak diedit sembarangan
        // })->get();
        $users = User::with(['roles', 'permissions'])->get();
        return view('users.index', compact('users'));
    }

    // Form Tambah User & Ceklis Menu
    public function create()
    {
        $permissions = Permission::all(); // Ambil semua opsi menu
        return view('users.create', compact('permissions'));
    }

    // Simpan User Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'permissions' => 'array' // Array hasil ceklis
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        // Assign Role default Staff
        $user->assignRole('staff');

        // Sinkronisasi Permission (Menu yang diceklis)
        if($request->has('permissions')){
            $user->syncPermissions($request->permissions);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat');
    }

    // Form Edit User & Ceklis Menu
    public function edit(User $user)
    {
        $permissions = Permission::all();
        return view('users.edit', compact('user', 'permissions'));
    }

    // Update User
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'permissions' => 'array'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username
        ]);
        
        if($request->filled('password')){
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Update Ceklis Menu
        if($request->has('permissions')){
            $user->syncPermissions($request->permissions);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        // Proteksi: Hanya Superadmin yang boleh menghapus
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'Akses ditolak.');
        }

        // Proteksi: Mencegah superadmin menghapus dirinya sendiri
        if (auth()->user()->id === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}