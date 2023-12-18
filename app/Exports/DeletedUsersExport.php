<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DeletedUsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $query;
    public function __construct($query)
    {
        $this->query = $query;
    }
    public function collection()
    {

        $records = $this->query->get();
        $result = array();
        foreach($records as $record){
            $result[] = array(
                'name' => $record->name,
                'upline'=> $record->parent ? $record->parent->email : null,
                'rank' => $record->rank->name,
                'email' => $record->email,
                'contact' => $record->contact_number,
                'country' => $record->country,
                'status' => User::getUserStatus($record->status),
                'deleted_at' => $record->deleted_at,
            );
        }

        return collect($result);

    }

    public function headings(): array
    {
        return [
            'Name',
            'Upline Email',
            'Rank',
            'Email',
            'Contact',
            'Country',
            'Status',
            'Deleted Date',
        ];
    }
}
