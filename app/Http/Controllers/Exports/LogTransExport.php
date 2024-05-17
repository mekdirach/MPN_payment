<?php

namespace App\Http\Controllers\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class LogTransExport implements FromCollection
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Pastikan $this->data sesuai dengan format yang diharapkan
        return collect($this->data->toArray());
    }

    public function headings(): array
    {
        // Define the column headings based on your data structure
        return [
            'TANGGAL',
            'BILL ID',
            'NTB',
            'NTPN',
            'BANK REFNUM',
            'NPWP',
            'NAMA WAJIB PAJAK',
            'NAMA WAJIB BAYAR',
            'AMOUNT',
            'BATCH ID',
            'NO SAKTI',
            'USER',
            'SRC ACC NUMBER',
            'STATUS',
        ];
    }
}
