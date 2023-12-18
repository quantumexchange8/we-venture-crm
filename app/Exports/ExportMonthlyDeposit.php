<?php

namespace App\Exports;

use App\Models\Deposits;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * @return \Illuminate\Support\Collection
 */
class ExportMonthlyDeposit implements FromCollection, WithHeadings {
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
                'transaction_date' => $record->month_year ?? $record->date,
                'name' => $record->user->name,
                'email' => $record->user->email,
                'broker' => $record->broker->name,
                'deposit_amount' => number_format($record->dep_amount, 2),
                'withdrawal_amount' => number_format($record->with_total, 2),
            );
        }

        return collect($result);

    }

    public function headings(): array
    {
        return [
            'Transaction Date',
            'Client Name',
            'Client Email',
            'Broker',
            'Deposit Amount',
            'Withdrawal Amount (capital)',
        ];
    }
}
