<?php

namespace App\Exports\Exports;


use App\Models\Positions;
use App\Models\Program;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProgramExport implements FromCollection, WithHeadings
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
            'season name',
            'Sport Name',
            'League age Date',
            'Program Fee',
            'jersey Fee',
            'status',
            'created at'

        ];
    }
    public function collection()
    {
        $certifcates = Program::all();
        foreach ($certifcates as $i => $cert) {
            $cert->sport_id = $cert->sport ? $cert->sport->name : "";
            $cert->season_id = $cert->seasion ? $cert->seasion->name : "";
        }
        return $certifcates;
    }
}
