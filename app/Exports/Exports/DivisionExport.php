<?php

namespace App\Exports\Exports;


use App\Models\Club;
use App\Models\Conference;
use App\Models\Division;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DivisionExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            '#',
            'code',
            'short Name',
            'name',
            'share field',
            'badge color',
            'badge color hex',
            'text color',
            'age group',
            'Playdown Age',
            'Status',
            'created at',


        ];
    }
    public function collection()
    {
        $certifcates = Division::all();
        foreach ($certifcates as $i => $cert) {
        }
        return $certifcates;
    }
}
