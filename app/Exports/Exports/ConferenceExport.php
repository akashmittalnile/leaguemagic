<?php

namespace App\Exports\Exports;


use App\Models\Club;
use App\Models\Conference;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConferenceExport implements FromCollection, WithHeadings
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
            'title',
            'created By',
            'status',
            'created at'

        ];
    }
    public function collection()
    {
        $certifcates = Conference::all();
        foreach ($certifcates as $i => $cert) {

            $cert->created_by = $cert->user->name;
        }
        return $certifcates;
    }
}
