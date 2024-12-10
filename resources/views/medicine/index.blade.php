@extends('layouts.layout')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success"> {{ Session::get('success') }}</div>
    @endif

    <a href="{{ route('obat.data.export') }}" class="btn btn-success">Export Excel</a>

    <div class="container mt-5">
        <table class="table table-striped table-bordered table-secondary" >
            <thead>
                <tr>
                    <th>no</th>
                    <th>Nama obat</th>
                    <th>Tipe</th>
                    <th>Harga</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (count($medicine) < 1)
                    <tr>
                        <td colspan="6" class="text-center">Data obat kosong</td>
                    </tr>
                @else
                    @foreach ($medicine as $index => $item)
                        <tr>
                            <td>{{ ($medicine->currentPage() - 1) * $medicine->perPage() + ($index + 1) }}
                            </td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class=" text-center {{ $item['stock'] <= 3 ? 'bg-danger text-white' : '' }}"
                                style="cursor: pointer"
                                onclick="showModalStock('{{ $item->id }}', '{{ $item->stock }}')">{{ $item['stock'] }}
                            </td>
                            <td class="d-flex justify-content-center gap-2">
                                {{-- <button class="btn btn-primary me-2" >Edit</button> --}}
                                <a href="{{ route('obat.edit', $item['id']) }}" class="btn btn-primary me-2">Edit</a>
                                <button class="btn btn-danger"
                                    onclick="showModal ('{{ $item->id }}' , '{{ $item->name }}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        {{-- modal hapus stock --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form-delete-obat" method="POST">
                    @csrf
                    {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
                    method untul menghapus data- --}}
                    @method('DELETE')
                    <div class="modal-content" style="color: black">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data Obat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin ingin menghapus obat <span id="nama-obat"></span>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <button type="submit" class="btn btn-danger" id="confirm-delete">Hapus</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- modal edit stock --}}
        <div class="modal fade" id="modal_edit_stock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form_edit_stock" method="POST">
                    @csrf
                    {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
                    method untul menghapus data- --}}
                    @method('PATCH')
                    <div class="modal-content" style="color: black">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Stock Obat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="stock_edit" class="form-label">Stok :</label>
                                <input type="number" name="stock" id="stock_edit" class="form-control">
                                @if (Session::get('failed'))
                                    <small class="text-danger">{{ Session::get('failed') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary me-2" id="confirm-delete">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-end">{{ $medicine->links() }}</div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        function showModal(id, name) {
            // ini untuk url delete nya (Route)
            let urlDelete = "{{ route('obat.hapus', ':id') }}";
            // ganti id di url dengan id yang dikirim
            urlDelete = urlDelete.replace(':id', id);

            //Ini untuk action attributnya
            $('#form-delete-obat').attr('action', urlDelete);
            // ini untuk show modalnya
            $('#exampleModal').modal('show');
            // ini untuk mengisi modalnya
            $('#nama-obat').text(name);
        }

        function showModalStock(id, stock) {
            // mengisi stock yang dikirim ke input yang id nya stock edit
            $('#stock_edit').val(stock);
            // ambil route patch stock
            let url = "{{ route('obat.edit.stock', ':id') }}";
            // isi patch dinamis :id dengan id dari parameter ($item->id)
            url = url.replace(":id", id);
            // url td kirim ke action
            $("#form_edit_stock").attr("action", url);
            // ini untuk show modalnya
            $('#modal_edit_stock').modal('show');
        }

        @if (Session::get('failed'))
            // jika halaman htmlnya sudah selesai load cdn, jalankan di dalamannya
            $(document).ready(function() {
                // id dari with failed 'id' controller redirect back
                let id = "{{ Session::get('id') }}";
                // id dari with failed 'stock' controller redirect back
                let stock = "{{ Session::get('stock') }}";
                // id dari function showModalStock dengan data id dan stock diatas
                showModalStock(id, stock);
            });
        @endif
    </script>
@endpush
