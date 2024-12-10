@extends('layouts.layout')

@section('content')
    <div class="container mt-3">
        <!-- Success message display -->
        @if (Session::get('success'))
            <div class="alert alert-success text-center">
                {{ Session::get('success') }}
            </div>
        @endif


        <form class="d-flex" role="search" action="" method="GET">
            <input type="date" class="form-control me-2" placeholder="Search Data Obat" aria-label="Search"
                name="search_data_pembelian" value="{{ request('search_data_pembelian') }}">
            <button class="btn btn-primary" type="submit">Search</button>
            <div class="d-flex justify-content-end  ">
                <a href="{{ route('pembelian.admin') }}" class="btn btn-primary">Clear</a>
            </div>
        </form>


        <a href="{{ route('pembelian.admin.export') }}" class="btn btn-success">Export Excel</a>

        <!-- Orders Table -->
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Pembeli</th>
                    <th>Obat</th>
                    <th>Total Bayar</th>
                    <th>Tanggal pembelian</th>
                    <th>Nama Kasir</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($orders as $item)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $item->name_customer }}</td>
                        <td>
                            <ul class="list-unstyled">
                                @foreach ($item['medicines'] as $medicine)
                                    <li>
                                        {{ $medicine['name_medicine'] }}
                                        (Rp. {{ number_format($medicine['price'], 0, ',', '.') }})
                                        :
                                        Rp. {{ number_format($medicine['total_price'], 0, ',', '.') }}
                                        <small>qyt {{ $medicine['qyt'] }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>Rp. {{ number_format($item['total_price'], 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item['created_at'])->locale('id')->isoFormat('D MMMM YYYY HH:mm:ss') }}
                        </td>
                        <td>{{ $item['user']['name'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="d-flex justify-content-end">
            @if ($orders->count() > 0)
                {{ $orders->links() }}
            @endif
        </div>
    </div>
@endsection
