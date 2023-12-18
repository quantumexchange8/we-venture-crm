<?php

namespace App\Exports;

use App\Models\WorldPoolHistory;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorldPoolHistoryExport implements FromCollection, WithHeadings
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
        $records = $this->query->whereHas('user', function($q) {
            $q->whereNull('deleted_at');
        })->get();

        $result = array();
        foreach($records as $world_pool){
            $result[] = array(
                'name' =>  $world_pool->user->name,
                'email' =>  $world_pool->user->email,
                'pool_type' => $world_pool->pool_type,
                'total_lot' =>  number_format((float)$world_pool->total_lot, 2, '.', ''),
                'net_lot' => number_format((float)$world_pool->net_lot, 2, '.', ''),
                'pool_commission' => $world_pool->pool_commission,
                'pool_amount' => number_format((float)$world_pool->pool_amount, 2, '.', ''),
                'from_time' => Carbon::parse($world_pool->from_time)->format('Y-m-d H:i:s'),
                'to_time' => Carbon::parse($world_pool->to_time)->format('Y-m-d H:i:s'),
            );
        }

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Pool Type',
            'Total Lot',
            'Net Lot',
            'Pool Commission',
            'Pool Amount',
            'Start Time',
            'End Time',
        ];
    }
}
