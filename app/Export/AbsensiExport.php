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
    public function __construct($data, $total_pertemuan=14)
    {
        $this->data = $data;
        $this->total_pertemuan = $total_pertemuan;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        $headings = [
            'NIM',
            'Nama Mahasiswa',
            'Mata Kuliah',
            'Waktu',
        ];

        // $len = count($this->data->get(0)) - 6;
        for ($i=1; $i <= $this->total_pertemuan; $i++) { 
          $headings[] = 'P '.$i;
        }

        return $headings;
        
    }

    public function map($data): array
    {
        $hari = dayname(explode(' ', $data['start_at'])[0]);
        $start = explode(' ', $data['start_at'])[1];
        $end = explode(' ', $data['finish_at'])[1];
        $map = [
            $data['nim'],
            $data['nama_mahasiswa'],
            $data['mata_kuliah'],
            $hari.', '.$start.' - '.$end,
        ];


        for ($i=1; $i <= $this->total_pertemuan; $i++) {
            $map[] = $data['p_'.$i];
        }

        return $map;
    }

}