<?php

namespace App\Exports\Exports;


use App\Models\Positions;
use App\Models\Program;
use App\Models\Reagion;
use App\Models\Seasons;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SeasonExport implements FromCollection, WithHeadings
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
            'created_by',
            'status',
            'created at'

        ];
    }
    public function collection()
    {
        $certifcates = Seasons::all();
        foreach ($certifcates as $i => $cert) {
            $cert->created_by = $cert->user ? $cert->user->name : "";
        }
        return $certifcates;
    }
}
