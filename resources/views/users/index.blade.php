@extends('layouts.layout2')

@section('content')
    <div class="container">
        <h2 class="text-center fw-bold">Halaman User</h2>

        <a href="{{ route('kelola.tambah') }}" class="btn btn-primary mb-3">Tambah Pengguna</a>
        <a href="{{ route('kelola.akun.admin') }}" class="btn btn-success">Export Excel</a>


        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        <table class="table table-bordered table-secondary">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('kelola.edit', $user->id) }}" class="btn btn-primary">Edit</a>

                            <button class="btn btn-danger"
                                onclick="showModal('{{ $user->id }}', '{{ $user->name }}')">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form-delete-akun" method="POST">
                    @csrf
                    {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
                method untul menghapus data- --}}
                    @method('DELETE')
                    <div class="modal-content" style="color: black">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin ingin menghapus <span id="nama-akun"></span>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <button type="submit" class="btn btn-danger" id="confirm-delete">Hapus</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function showModal(id, name) {
            //ini untuk url delete nya(Route)
            let urlDelete = "{{ route('kelola.hapus', ':id') }}";
            urlDelete = urlDelete.replace(':id', id);

            //ini untuk action attributnya
            $('#form-delete-akun').attr('action', urlDelete);

            //ini untuk show modal nya
            $('#exampleModal').modal('show');

            //ini untuk mengisi modalnya
            $('#nama-akun').text(name);
        }
    </script>
@endpush
