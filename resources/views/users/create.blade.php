@extends('layouts.layout')
@section('content')
<h2 class="text-center container mt-2">HALAMAN MEMBUAT AKUN</h2>
    <form action="{{ route('kelola.tambah.formulir') }}" method="POST" class="card p-5 container mt-5 bg-light.bg-gradient">

        {{--
            1.tag <form> attr action & method
                method:
                - GET : form tujuan mencari data (search)
                - GET : form tujuan menambahkan/menghapus/mengubah
                action : route memproses data
                - arahkan route yang akan menangani proses data yang ke db nya
                - jika GET : arahkan ke route yang sama dengan route yang menampilkan blade ini
        --}}

        @csrf
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
        </div>


        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email :</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Password :</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Role :</label>
            <div class="col-sm-10">
                <select class="form-select" id="role" name="role">
                    <option selected disabled hidden>Pilih</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>cashier</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Tambah Data</button>
    </form>
@endsection
