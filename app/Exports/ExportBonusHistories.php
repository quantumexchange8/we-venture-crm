<?php

namespace App\Exports;

use App\Models\BonusHistories;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportBonusHistories implements FromCollection, WithHeadings
{
    private $query;
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        $records = $this->query->whereHas('commission', function($q) {
            $q->whereNull('deleted_at')->orderBy('transaction_at', 'DESC');
        })->get();

        $result = array();
        foreach($records as $commission){
            $result[] = array(
                'transaction_date' => Carbon::parse($commission->commission->transaction_at)->format('Y-m-d H:i:s'),
                'lot_size' =>  number_format((float)$commission->commission_lot, 2, '.', ''),
                'commissions' =>  number_format((float)$commission->bonus_amount, 2, '.', ''),
                'email' => $commission->commission->user->email,
                'broker' => $commission->commission->broker->name,
                'upload_date' => Carbon::parse($commission->commission->created_at)->format('Y-m-d H:i:s'),
            );
        }

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'Transaction Date',
            'Lot Size',
            'Commissions Amount',
            'Client Email',
            'Broker',
            'Uploaded Date',
        ];
    }
}
