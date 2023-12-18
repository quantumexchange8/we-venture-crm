<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportWalletLogs implements FromCollection, WithHeadings
{
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $records = $this->query->get();
        $result = array();
        foreach($records as $record){
            $result[] = array(
                'name' => $record->user->name,
                'email' => $record->user->email,
                'old_balance' => number_format($record->old_balance, 2),
                'new_balance' => number_format($record->new_balance, 2),
                'amount' => number_format($record->amount, 2),
                'remark' => $record->remark,
                'date_submitted' => $record->created_at,
            );
        }

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Old Balance',
            'New Balance',
            'Amount',
            'Remark',
            'Date Submitted'
        ];
    }
}
