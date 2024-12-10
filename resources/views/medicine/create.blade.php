@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Masukkan Data Obat</h1>
        <form action="{{ route('obat.tambah.formulir') }}" method="POST" class="card p-5 shadow-sm rounded">
            @csrf
            @if (Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Form fields --}}
            <div class="mb-4 row">
                <label for="name" class="col-sm-2 col-form-label fw-bold">Nama Obat :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-lg" id="name" name="name"
                        value="{{ old('name') }}" placeholder="Masukkan nama obat" required>
                </div>
            </div>

            <div class="mb-4 row">
                <label for="type" class="col-sm-2 col-form-label fw-bold">Jenis Obat :</label>
                <div class="col-sm-10">
                    <select class="form-select form-select-lg" id="type" name="type" required>
                        <option selected disabled hidden>Pilih jenis obat</option>
                        <option value="tablet" {{ old('type') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                        <option value="sirup" {{ old('type') == 'sirup' ? 'selected' : '' }}>Sirup</option>
                        <option value="kapsul" {{ old('type') == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                    </select>
                </div>
            </div>

            <div class="mb-4 row">
                <label for="price" class="col-sm-2 col-form-label fw-bold">Harga Obat :</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control form-control-lg" id="price" name="price"
                        value="{{ old('price') }}" placeholder="Masukkan harga obat" required>
                </div>
            </div>

            <div class="mb-4 row">
                <label for="stock" class="col-sm-2 col-form-label fw-bold">Stok Tersedia :</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control form-control-lg" id="stock" name="stock"
                        value="{{ old('stock') }}" placeholder="Masukkan jumlah stok" required>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary btn-lg mt-3">
                    <i class="fas fa-plus me-2"></i> Tambah Data
                </button>
            </div>
        </form>
    </div>
@endsection
