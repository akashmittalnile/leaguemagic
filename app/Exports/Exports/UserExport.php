<?php

namespace App\Exports\Exports;


use App\Models\Positions;
use App\User;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class userExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        $user = new User();
        $tableName = $user->getTable();

        $columns = Schema::getColumnListing($tableName);
        if (($key = array_search('updated_at', $columns)) !== false) {
            unset($columns[$key]);
        }

        if (($key = array_search('password', $columns)) !== false) {
            unset($columns[$key]);
        }
        if (($key = array_search('remember_token', $columns)) !== false) {
            unset($columns[$key]);
        }

        return $columns;
    }
    public function collection()
    {
        $users = User::all();
        $users->makeHidden(['password', "updated_at", "remember_token"]);
        foreach ($users as $i => $cert) {
            $cert->role_id = $cert->role ? $cert->role->name : "User";
            $cert->position_id = $cert->position ? $cert->position->name : "User";
            $cert->state_id = $cert->state ? $cert->state->name : "US";
        }
        return $users;
    }
}
