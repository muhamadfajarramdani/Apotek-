<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::orderBY('created_at', 'DESC')->get();
    }

    public function headings(): array
    {
        //membuat th
        return [
            'No',
            'ID',
            'Nama',
            'Email',
            'Role',
        ];
    }

    private $rowNumber = 1;



    public function map($user): array
    {
        return [
            $this->rowNumber++,
            $user->id,
            $user->name,
            $user->email,
            $user->role,
            \Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY'),
        ];
    }
}
