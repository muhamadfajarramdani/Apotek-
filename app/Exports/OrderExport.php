<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //menentukan data yang akan di munculkan di excel
        return Order::with('user')->orderBY('created_at', 'DESC')->get();
    }

    public function headings(): array
    {
        //membuat th
        return [
            'ID',
            'Nama Kasir',
            'Daftar obat',
            'Nama pembeli',
            'Total Harga',
            'Tanggal'
        ];
    }

    public function map($order): array
    {
        // 1. Antangin (2pcs) Rp. 5000, 2.......
        //string penampung data data obat
        $daftarObat = "";
        foreach ($order->medicines as $key => $value) {
            $obat = $key + 1 . '. ' . $value['name_medicine'] . " (" . $value['qyt'] ." pcs ) "
                . 'Rp. ' . number_format($value['total_price'], 0, ',', '.') . ",";
            //menggabungkan nilai di $daftarObat dengan string $obat
            $daftarObat .= $obat;
        }
        return [
            $order->id,
            $order->user->name,
            $daftarObat,
            $order->name_customer,
            "Rp. " . number_format($order->total_price, 0, ',', '.'),
            $order->created_at->isoFormat('D MMMM YYYY HH:mm:ss')
        ];
    }
}
