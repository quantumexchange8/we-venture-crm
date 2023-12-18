<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUser implements FromCollection, WithHeadings
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
            foreach($records as $user){
                $result[] = array(
                    'name' => $user->name,
                    'rank' => $user->rank->name,
                    'email' => $user->email,
                    'contact' => $user->contact_number,
                    'country' => $user->country,
                    'status' => User::getUserStatus($user->status),
                );
            }
        } else {
            foreach($records as $user){
                $result[] = array(
                    'name' => $user->name,
                    'upline'=> $user->parent ? $user->parent->email : null,
                    'first_leader'=> $user->getLeaders()['first_leader'],
                    'top_leader'=> $user->getLeaders()['top_leader'],
                    'rank' => $user->rank->name,
                    'email' => $user->email,
                    'contact' => $user->contact_number,
                    'country' => $user->country,
                    'status' => User::getUserStatus($user->status),
                    'joined_date' => $user->created_at,
                    'kyc' => User::getUserKYCStatus($user->kyc_approval_status),
                    'personal_invest' => $user->personalDeposits(),
                    'total_group_sales' => $user->groupTotalDeposit(),
                );
            }
        }


        return collect($result);

    }

    public function headings(): array
    {
        if ($this->not_admin) {
            return [
                'Name',
                'Rank',
                'Email',
                'Contact',
                'Country',
                'Status',
            ];
        } else {
            return [
                'Name',
                'Upline Email',
                'First Leader Email',
                'Top Leader Email',
                'Rank',
                'Email',
                'Contact',
                'Country',
                'Status',
                'Joined Date',
                'KYC Status',
                'Total Personal Invest',
                'Total Group Sales'
            ];
        }

    }
}
