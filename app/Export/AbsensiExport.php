<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    protected $data;
    protected $total_pertemuan;
    public function __construct($absensi)
    {
        $this->absensi = $absensi;
    }

    public function collection()
    {
        return collect($this->absensi['data']);
    }

    public function headings(): array
    {
        return $this->absensi['heading'];
    }

    public function map($data): array
    {
        return array_values($data);
    }

}