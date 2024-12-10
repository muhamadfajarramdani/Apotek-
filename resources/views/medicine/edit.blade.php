@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Halaman Edit Obat</h1>
        <form action="{{ route('obat.edit.formulir', $medicine['id']) }}" method="POST" class="card p-5 shadow-sm rounded">
            @csrf
            @method('PATCH')
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
                        value="{{ $medicine['name'] }}" placeholder="Masukkan nama obat" required>
                </div>
            </div>

            <div class="mb-4 row">
                <label for="type" class="col-sm-2 col-form-label fw-bold">Jenis Obat :</label>
                <div class="col-sm-10">
                    <select class="form-select form-select-lg" id="type" name="type" required>
                        <option selected disabled hidden>Pilih jenis obat</option>
                        <option value="tablet" {{ $medicine['type'] == 'tablet' ? 'selected' : '' }}>Tablet</option>
                        <option value="sirup" {{ $medicine['type'] == 'sirup' ? 'selected' : '' }}>Sirup</option>
                        <option value="kapsul" {{ $medicine['type'] == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                    </select>
                </div>
            </div>

            <div class="mb-4 row">
                <label for="price" class="col-sm-2 col-form-label fw-bold">Harga Obat :</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control form-control-lg" id="price" name="price"
                        value="{{ $medicine['price'] }}" placeholder="Masukkan harga obat" required>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary btn-lg mt-1">
                    <i class="fas fa-plus me-2"></i> Tambah Data
                </button>
            </div>
        </form>
    </div>
@endsection
