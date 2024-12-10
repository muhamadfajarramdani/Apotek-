<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk Pembelian - Apotek Sejahtera Abadi</title>
    <link rel="stylesheet" href="styles.css">
</head>

<style>
    /* Reset margin and padding */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Container styling */
    .container {
        width: 60%;
        margin: auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        font-family: Arial, sans-serif;
    }

    /* Header styling */
    .header {
        color: #333;
    }

    .header h4 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .header p {
        margin: 3px 0;
        font-size: 14px;
    }

    .address {
        font-style: italic;
        color: #555;
    }

    /* Table styling */
    .table {
        width: 100%;
        margin-top: 15px;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
        font-size: 14px;
    }

    .table th {
        background-color: #007bff;
        color: #fff;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* Row for tax and total */
    .table tr:last-child td,
    .table tr:nth-last-child(2) td {
        font-weight: bold;
        text-align: right;
    }

    /* Footer text styling */
    .footer-text {
        text-align: center;
        font-size: 14px;
        color: #555;
        margin-top: 20px;
        font-style: italic;
    }

    /* Responsive styling */
    @media (max-width: 768px) {
        .container {
            width: 90%;
        }

        .header h4 {
            font-size: 20px;
        }

        .table th,
        .table td {
            padding: 8px;
        }
    }
</style>


<body>
    <div class="container mt-3">
        <div class="header text-center mb-4">
            <h4>Apotek Sejahtera Abadi</h4>
            <p class="address">Alamat: Sepanjang Jalan Kenangan</p>
            <p>Email: apoteksejahteraabadi@gmail.com | Phone: 0857-1903-4643</p>
        </div>

        <hr>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama Pembeli</th>
                    <th>Obat</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td rowspan="{{ count($order['medicines']) + 2 }}">{{ $order['name_customer'] }}</td>
                </tr>

                @php
                    $totalPrice = $order['total_price'] / 1.1;
                    $tax = $totalPrice * 0.1;
                    $totalWithTax = $totalPrice + $tax;
                @endphp

                @foreach ($order['medicines'] as $item)
                    <tr>
                        {{-- <td>{{ $order['name_customer'] }}</td> --}}
                        <td>{{ $item['name_medicine'] }}</td>
                        <td>{{ $item['qyt'] }}</td>
                        <td>Rp. {{ number_format($item['total_price'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-end">PPN (10%)</td>
                    <td>Rp. {{ number_format($tax, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end">Total Harga</td>
                    <td>Rp. {{ number_format($totalWithTax, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <p class="footer-text">
            Terima kasih atas pembelian Anda! Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Maiores natus et numquam ducimus dolorum tenetur.
        </p>

    </div>
</body>

</html>
