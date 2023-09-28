<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //Tampilkan formulir untuk pengisian data administrator baru.
    public function create() 
    {
        return view('admin.add');
    }

    //Simpan informasi administrator ke dalam tabel.
    public function store(Request $request)
    {
        //Verifikasi masukan dari formulir.
        $request->validate([
            'id_admin' => 'required',
            'nama_admin' => 'required',
            'alamat' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        //Simpan informasi administrator ke dalam tabel menggunakan DB::insert.
        DB::insert(
            'INSERT INTO admin(id_admin,nama_admin, alamat, username, password) VALUES (:id_admin, :nama_admin, :alamat, :username, :password)',
            [
                'id_admin' => $request->id_admin,
                'nama_admin' => $request->nama_admin,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => $request->password,
            ]
        );

        //Pindah ke halaman indeks dengan pesan "success".
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil disimpan');
    }

    //Tampilkan semua informasi administrator dari tabel.
    public function index()
    {
        $datas = DB::select('select * from admin');
        return view('admin.index')->with('datas', $datas);
    }

    //Tampilkan formulir untuk mengubah data administrator.
    public function edit($id)
    {
        //Ambil informasi administrator berdasarkan ID.
        $data = DB::table('admin')->where('id_admin', $id)->first();
        return view('admin.edit')->with('data', $data);
    }

    //Perbarui informasi administrator dalam tabel.
    public function update($id, Request $request)
    {
        //validasi input dari form
        $request->validate([
            'id_admin' => 'required',
            'nama_admin' => 'required',
            'alamat' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);
        //Lakukan pembaruan informasi administrator dalam tabel dengan menggunakan DB::update.
        DB::update(
            'UPDATE admin SET id_admin = :id_admin, nama_admin = :nama_admin, alamat = :alamat, username = :username, password = :password WHERE id_admin = :id',
            [
                'id' => $id,
                'id_admin' => $request->id_admin,
                'nama_admin' => $request->nama_admin,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => $request->password,
            ]
        );
        //Pindah ke halaman indeks dengan pesan "sukses".
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil diubah');
    }

    //Hapus informasi administrator dari tabel.
    public function delete($id)
    {
        //Hapus informasi administrator berdasarkan ID.
        DB::delete('DELETE FROM admin WHERE id_admin = :id_admin', ['id_admin' => $id]);
        //Pindah ke halaman indeks dengan pesan "succsess".
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil dihapus');
    }


}
