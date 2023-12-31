<?php

namespace App\Exports\Exports;


use App\Models\Positions;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PositionExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        $post = new Positions();
        $tableName = $post->getTable();

        $columns = Schema::getColumnListing($tableName);
        if (($key = array_search('updated_at', $columns)) !== false) {
            unset($columns[$key]);
        }

        if (($key = array_search('sort_order', $columns)) !== false) {
            unset($columns[$key]);
        }

        return $columns;
    }
    public function collection()
    {
        $certifcates = Positions::all();
        foreach ($certifcates as $i => $cert) {
            $cert->created_by = $cert->user ? $cert->user->name : "Admin";
        }
        return $certifcates;
    }
}
