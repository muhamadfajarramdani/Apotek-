@extends('layouts.layout')

@section('content')
    <div class="container mt-3">
        <div class="text-end mb-3">
            <a href="{{ route('pembelian.download_pdf', $order['id']) }}">
                <i class="fas fa-print"></i> Cetak (.pdf)
            </a>
        </div>

        <div class="text-center mb-4">
            <h4 class="font-weight-bold">Apotek Sejahtera Abadi</h4>
            <p class="lead">Alamat: Sepanjang Jalan Kenangan</p>
            <p>Email: apoteksejahteraabadi@gmail.com | Phone: 0857-1903-4643</p>
        </div>

        <hr>

        <table class="table table-bordered table-hover">
            <thead>
                <tr class="table-primary">
                    <th>Nama Pembeli</th>
                    <th>Obat</th>
                    <th>Total</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <!-- Menampilkan nama pembeli hanya satu kali -->
                <tr>
                    <td rowspan="{{ count($order['medicines']) + 2 }}">{{ $order['name_customer'] }}</td>
                </tr>

                <!-- Looping untuk obat yang dibeli -->
                @php
                    $totalPrice = $order['total_price'] / 1.1;
                    $tax = $totalPrice * 0.1;
                    $totalWithTax = $totalPrice + $tax;
                @endphp

                @foreach ($order['medicines'] as $item)
                    <tr>
                        <td>{{ $item['name_medicine'] }}</td>
                        <td>{{ $item['qyt'] }}</td>
                        <td>Rp. {{ number_format($item['total_price'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                <!-- PPN dan Total Harga -->
                <tr>
                    <td colspan="2" class="text-end font-weight-bold">PPN (10%)</td>
                    <td>Rp. {{ number_format($tax, 0, ',', '.') }}</td>
                </tr>
                <tr class="font-weight-bold">
                    <td colspan="3" class="text-end">Total Harga</td>
                    <td>Rp. {{ number_format($totalWithTax, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <p class="text-center mt-3">
            Terima kasih atas pembelian Anda! Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Maiores natus et numquam ducimus dolorum tenetur.
        </p>

        <div class="text-center mt-4">
            <a href="{{ route('pembelian.formulir') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                color: #333;
                background: #fff;
            }

            .btn,
            .navbar,
            .footer {
                display: none !important;
            }

            .container {
                max-width: 600px;
                margin: auto;
                padding: 20px;
                box-shadow: none;
                border: 1px solid #ddd;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                padding: 12px;
                border: 1px solid #ddd;
                text-align: center;
            }

            th {
                background-color: #f7f7f7;
                color: #333;
            }

            .btn-print {
                transition: background-color 0.3s, transform 0.3s;
            }

            .btn-print:hover {
                background-color: #0056b3;
                transform: scale(1.05);
            }
        }
    </style>
@endsection
