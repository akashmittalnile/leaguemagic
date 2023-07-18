<?php

namespace App\Exports\Exports;

use App\Models\Certificate;
use App\Models\Club;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClubExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            '#',
            'confrence',
            'region',
            'Player Import',
            'status',
            'schedule code',
            'created By',
            'status',
            'created at'

        ];
    }
    public function collection()
    {
        $certifcates = Club::all();
        foreach ($certifcates as $i => $cert) {
            $cert->conference_id = $cert->confrence->name;
            $cert->region_id = $cert->region->name;
            $cert->created_by = $cert->user->name;
        }
        return $certifcates;
    }
}
