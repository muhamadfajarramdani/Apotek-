<?php

namespace App\Exports;

use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ObatExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    */
    public function collection()
    {
        return Medicine::orderBY('created_at', 'DESC')->get();
    }

        public function headings(): array
        {
            //membuat th
            return [
                'No',
                'ID',
                'Nama Obat',
                'Tipe',
                'Harga',
                'Stock',
                'Waktu',
            ];
        }

    private $rowNumber = 1;

    public function map($medicine): array
    {
        return [
            $this->rowNumber++,
            $medicine->id,
            $medicine->name,
            $medicine->type,
            $medicine->price,
            $medicine->stock,
            \Carbon\Carbon::parse($medicine->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY'),
        ];
    }
}
