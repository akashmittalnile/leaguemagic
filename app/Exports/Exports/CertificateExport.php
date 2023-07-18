<?php

namespace App\Exports\Exports;

use App\Models\Certificate;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CertificateExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            '#',
            'Group',
            'name',
            'duration',
            'created_by',
            'status',
            'created at'

        ];
    }

    public function collection()
    {
        $certifcates = Certificate::get(['id', 'group_id', 'name', 'duration', 'created_by', 'status', 'created_at']);
        foreach ($certifcates as $i => $cert) {
            $cert->group_id = $cert->confrence->name;
            $cert->duration = $cert->duration . " Year";
            $cert->created_by = $cert->user->name;
        }
        return $certifcates;
    }
}
