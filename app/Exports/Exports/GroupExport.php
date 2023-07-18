<?php

namespace App\Exports\Exports;


use App\Models\Club;
use App\Models\Group;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GroupExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            '#',

            'short Name',
            'name',

            'Status',
            'Created By',

            'created at',


        ];
    }
    public function collection()
    {
        $certifcates = Group::all();
        foreach ($certifcates as $i => $cert) {
            $cert->created_by = $cert->user->name;
        }
        return $certifcates;
    }
}
