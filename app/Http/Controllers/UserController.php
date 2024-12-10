<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;

class UserController extends Controller
{
    public function exportExcelAkun()
    {
        return Excel::download(new UserExport, 'rekap-data-akun.xlsx');
    }
    public function index(Request $request)
    {

        $users = User::where('name', 'LIKE', '%' . $request->search_akun . '%')->orderBy('name','ASC')->simplePaginate(5);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = ['admin', 'user'];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . ($user->id ?? ''),
            'role' => 'required',
            'password' => 'min:8',
        ]);


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            // Untuk Encripsi data
            'password' => bcrypt($request->password)
        ]);
        return redirect()->route('kelola.akun')->with('success', 'data berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'password' => 'nullable'
        ]);

        // Ambil data akun dari database
        $user = User::where('id', $id)->first();

        // Trim input untuk menghindari perbedaan karena spasi
        $name = trim($request->name);
        $email = trim($request->email);
        $role = $request->role;

        // Bandingkan data input dengan data di database
        $isChanged = false;

        if (
            $user->name !== $name ||
            $user->email !== $email ||
            $user->role != $role
        ) {
            $isChanged = true;
        }

        // Jika ada perubahan, lakukan update
        if ($isChanged) {
            $updateSuccess = $user->update([
                'name' => $name,
                'email' => $email,
                'role' => $role,
                'password' => $request->password ? bcrypt($request->password) : $user->password
            ]);

            // Pastikan operasi update berhasil
            if ($updateSuccess) {
                return redirect()->route('kelola.akun')->with('success', "Data $name berhasil diupdate!");
            } else {
                return redirect()->route('kelola.akun')->with('error', 'Terjadi kesalahan saat mengupdate data.');
            }
        } else {
            // Jika tidak ada perubahan, kirim pesan bahwa tidak ada data yang diubah
            return redirect()->route('kelola.akun')->with('info', 'Tidak ada data yang diubah.');
        }
    }

    public function destroy(string $id)
    {
        $deleteData = User::where('id', $id)->delete();

        if ($deleteData) {
            return redirect()->back()->with('success', 'Berhasil menghapus data akun!');
        } else {
            return redirect()->back()->with('failed', 'Gagal menghapus data akun!');
        }
    }

    public function showLogin() {
        return view('pages.login');
    }

    public function login(Request $request) {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ]
            );

            $users = $request->only(['email', 'password']);
            if (Auth::attempt($users)) {
                return redirect()->route('landing_page');
            }
            else{
                return redirect()->back()->with('error', 'Email atau Password salah');
            }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'berhasil');
    }
}
