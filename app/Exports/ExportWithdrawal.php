<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Withdrawals;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportWithdrawal implements FromCollection, WithHeadings
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

        foreach ($records as $withdrawal) {
            $record = [
                'user_name' =>  $withdrawal->user->name,
                'user_upline_email' =>  $withdrawal->user->parent ? $withdrawal->user->parent->email : null,
                'user_email' =>  $withdrawal->user->email,
                'user_country' =>  $withdrawal->user->country,
                'requested_date' => Carbon::parse($withdrawal->created_at)->format('Y-m-d H:i:s'),
                'wallet_address' => $withdrawal->address,
                'amount' => number_format((float)$withdrawal->amount + $withdrawal->transaction_fee, 2, '.', ''),
                'transaction_fee' => number_format((float)$withdrawal->transaction_fee, 2, '.', ''),
                'net_amount' => number_format((float)$withdrawal->amount, 2, '.', ''),
                'wallet_type' =>  $withdrawal->getNetwork(),
                'status' => Withdrawals::getApprovalStatus($withdrawal->status),
            ];

            // Check if the user is an admin
            if (Auth::user()->role == User::ROLE_ADMIN) {
                // Add 'first_leader' after 'user_upline_email'
                $key = array_search('user_upline_email', array_keys($record));
                array_splice($record, $key + 1, 0, ['first_leader' => $withdrawal->user->getLeaders()['first_leader']]);
            }

            $result[] = $record;
        }
//        if ($this->filterUser) {
//            foreach($records as $withdrawal){
//                $result[] = array(
//                    'requested_date' => Carbon::parse($withdrawal->created_at)->format('Y-m-d H:i:s'),
//                    'wallet_type' =>  $withdrawal->getNetwork(),
//                    'address' => $withdrawal->address,
//                    'amount' => number_format((float)$withdrawal->amount, 2, '.', ''),
//                    'transaction_fee' => $withdrawal->transaction_fee,
//                    'status'=> Withdrawals::getApprovalStatus($withdrawal->status),
//                );
//            }
//
//        } else {
//            foreach($records as $withdrawal){
//                $result[] = array(
//                    'user_name' =>  $withdrawal->user->name,
//                    'user_upline_email' =>  $withdrawal->user->parent->email,
//                    'user_email' =>  $withdrawal->user->email,
//                    'requested_date' => Carbon::parse($withdrawal->created_at)->format('Y-m-d H:i:s'),
//                    'amount' => number_format((float)$withdrawal->amount, 2, '.', ''),
//                    'wallet_type' =>  $withdrawal->getNetwork(),
//                    'status'=> Withdrawals::getApprovalStatus($withdrawal->status),
//                );
//            }
//        }

        return collect($result);
    }

    public function headings(): array
    {

        $headings = [
                'User Name',
                'Upline Email',
                'User Email',
                'Country',
                'Requested Date',
                'Wallet Address',
                'Amount',
                'Transaction Fee',
                'Net Amount',
                'Wallet Type',
                'Status',
            ];

        if (Auth::user()->role == User::ROLE_ADMIN) {
            array_splice($headings, 2, 0, ['First Leader']);
        }

        return $headings;

    }
}
