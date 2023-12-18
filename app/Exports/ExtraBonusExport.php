<?php

namespace App\Exports;

use App\Models\ExtraBonus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * @return \Illuminate\Support\Collection
 */

class ExtraBonusExport implements FromCollection, WithHeadings
{
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
                'name' => $record->user->name,
                'email' => $record->user->email,
                'rank' => $record->user->rank->name,
                'country' => $record->user->country,
                'bonus_amount' => $record->bonus_amount,
                'date_created' => $record->created_at,
            );
        }

        return collect($result);

    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Rank',
            'Country',
            'Bonus Amount',
            'Date Created',
        ];
    }
}
