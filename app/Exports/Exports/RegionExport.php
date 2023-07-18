<?php

namespace App\Exports\Exports;


use App\Models\Positions;
use App\Models\Program;
use App\Models\Reagion;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegionExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            '#',
            'conference',
            ' name',
            'code',
            'created_by',

            'status',
            'created at'

        ];
    }
    public function collection()
    {
        $certifcates = Reagion::all();
        foreach ($certifcates as $i => $cert) {
            $cert->confefrence_id = $cert->confrence ? $cert->confrence->name : "";
            $cert->created_by = $cert->user ? $cert->user->name : "";
        }
        return $certifcates;
    }
}
