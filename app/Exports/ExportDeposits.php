<?php

namespace App\Exports;

use App\Models\Deposits;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
    * @return \Illuminate\Support\Collection
    */
class ExportDeposits implements FromCollection, WithHeadings {
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
    public function collection()
    {
        $records = $this->query->get();
        $result = array();
        foreach($records as $deposits){
            $result[] = array(
                'name' => $deposits->user->name,
                'email' => $deposits->user->email,
                'upline_email' => $deposits->user->parent ? $deposits->user->parent->email : null,
                'first_leader' => Auth::user()->role == User::ROLE_ADMIN ? $deposits->user->getLeaders()['first_leader'] : null,
                'user_country' =>  $deposits->user->country,
                'broker' => $deposits->broker->name,
                'pamm' => $deposits->pamm_id > 0 ? $deposits->pamm->name : 'N/A',
                'transaction_date' => Carbon::parse($deposits->transaction_at)->format('Y-m-d'),
                'amount' => number_format((float)$deposits->amount, 2, '.', ''),
                'type' => $deposits->type == Deposits::TYPE_DEPOSIT ? 'Deposit' : 'Withdrawal',
                'upload_date' => Carbon::parse($deposits->created_at)->format('Y-m-d'),
                'group_sales' => $deposits->user->leader_status ? $deposits->user->groupTotalDeposit() : 'Not Available',
                'remarks' => Auth::user()->role == User::ROLE_ADMIN ? $deposits->remarks : null,
            );
        }

        return collect($result);
    }

    public function headings(): array
    {
        $headings = [
            'Client Name',
            'Client Email',
            'Upline Email',
            'Country',
            'Broker',
            'PAMM',
            'Transaction Date',
            'Amount',
            'Type',
            'Uploaded Date',
            'Leader Group Sales'
        ];

        if (Auth::user()->role == User::ROLE_ADMIN) {
            array_splice($headings, 3, 0, ['First Leader']);
            $headings[] = 'Remarks';
        }

        return $headings;
    }

}
