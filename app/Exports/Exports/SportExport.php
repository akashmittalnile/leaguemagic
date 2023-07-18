<?php

namespace App\Exports\Exports;

use App\Models\Sport;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SportExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            '#',
            'name',
            'code',
            'isleague',
            'created_by',
            'status',
            'created at'
        ];
    }
    public function collection()
    {
        $certifcates = Sport::all();
        foreach ($certifcates as $i => $cert) {
            $cert->created_by = $cert->user ? $cert->user->name : "";
            $cert->isleague = $cert->isleague ? "yes" : "no";
        }
        return $certifcates;
    }
}
