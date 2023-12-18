<?php

namespace App\Exports;

use App\Models\Investment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvestmentsExport implements FromCollection, WithHeadings
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
                'portfolio' => $record->portfolio->name,
                'min_amount' => $record->portfolio->min_amount,
                'deposit_amount' => $record->deposit_amount,
                'status' => $record->status,
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
            'Portfolio',
            'Min Amount',
            'Deposit Amount',
            'Status',
            'Date Submitted',
        ];
    }
}
