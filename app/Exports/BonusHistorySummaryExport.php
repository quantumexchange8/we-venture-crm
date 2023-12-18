<?php

namespace App\Exports;

use App\Models\BonusHistories;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BonusHistorySummaryExport implements FromCollection, WithHeadings
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
        foreach($records as $summary){
            $result[] = array(
                'name' => $summary->name,
                'email' => $summary->email,
                'lot_size' =>  number_format((float)$summary->total_commission_lot, 2, '.', ''),
                'commissions' =>  number_format((float)$summary->total_bonus_amount, 2, '.', ''),
                'upload_date' => Carbon::parse($summary->created_at)->format('Y-m-d H:i:s'),
            );
        }

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'Client Name',
            'Client Email',
            'Total Lot Size',
            'Total Amount',
            'Date',
        ];
    }
}
