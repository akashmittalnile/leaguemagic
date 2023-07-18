<?php

namespace App\Exports\Exports;

use App\Models\Location;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LocationExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        $post = new Location;
        $tableName = $post->getTable();

        $columns = Schema::getColumnListing($tableName);
        return $columns;
    }
    public function collection()
    {
        $certifcates = Location::all();
        foreach ($certifcates as $i => $cert) {
        }
        return $certifcates;
    }
}
