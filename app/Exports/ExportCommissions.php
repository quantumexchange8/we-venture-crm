<?php

namespace App\Exports;

use App\Models\Commissions;
use App\Models\Deposits;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCommissions implements FromCollection, WithHeadings
{
    private $query;
    private $not_admin;
    public function __construct($query, $status=false)
    {
        $this->query = $query;
        $this->not_admin = $status;
    }
    public function collection()
    {
        $records = $this->query->get();

        $result = array();

        if ($this->not_admin) {
            foreach($records as $commission){
                $result[] = array(
                    'name' => $commission->user->name,
                    'email' => $commission->user->email,
                    'broker' => $commission->broker->name,
                    'transaction_date' => Carbon::parse($commission->transaction_at)->format('Y-m-d H:i:s'),
                    'lot_size' =>  number_format((float)$commission->lot_size, 2, '.', ''),
                    'commissions' =>  number_format((float)$commission->commissions_amount, 2, '.', ''),
                    'status' => $commission->status == Commissions::STATUS_PENDING ? 'Pending' : 'Calculated',
                    'upload_date' => Carbon::parse($commission->created_at)->format('Y-m-d H:i:s'),
                );
            }
        } else {
            foreach($records as $commission){
                $result[] = array(
                    'name' => $commission->user->name,
                    'email' => $commission->user->email,
                    'upline_email' => $commission->user->parent ? $commission->user->parent->email : null,
                    'broker' => $commission->broker->name,
                    'pamm' => $commission->pamm->name ?? 'N/A',
                    'transaction_date' => Carbon::parse($commission->transaction_at)->format('Y-m-d H:i:s'),
                    'lot_size' =>  number_format((float)$commission->lot_size, 2, '.', ''),
                    'commissions' =>  number_format((float)$commission->commissions_amount, 2, '.', ''),
                    'status' => $commission->status == Commissions::STATUS_PENDING ? 'Pending' : 'Calculated',
                    'upload_date' => Carbon::parse($commission->created_at)->format('Y-m-d H:i:s'),
                );
            }
        }

        return collect($result);

    }

    public function headings(): array
    {
        if ($this->not_admin) {
            return [
                'Client Name',
                'Client Email',
                'Broker',
                'Transaction Date',
                'Lot Size',
                'Commissions Amount',
                'Status',
                'Uploaded Date',
            ];
        } else {
            return [
                'Client Name',
                'Client Email',
                'Upline Email',
                'Broker',
                'PAMM',
                'Transaction Date',
                'Lot Size',
                'Commissions Amount',
                'Status',
                'Uploaded Date',
            ];
        }

    }
}
