<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NetworkExport implements FromCollection, WithHeadings
{
    private $result = array();
    private $query;
    private $not_admin;

    public function __construct($query, $status = false)
    {
        $this->query = $query;
        $this->not_admin = $status;
    }

    public function collection()
    {
        $records = $this->query;
        $count = 1;
        if ($this->not_admin) {
            foreach ($records as $user) {
                $this->result[] = array(
                    'name' => $user->name,
                    'email' => $user->email,
                    'rank' => $user->rank->name,
                    'wallet' => $user->wallet_balance,
                    'personal_deposit' => number_format($user->personalDeposits(), 2),
                    'group_deposit' => number_format($user->groupTotalDeposit(), 2),
                    'downlines' => $user->getClientsCount(),
                    'level' => $count,
                );

                $chilren = $user->children;
                if (!$chilren->isEmpty()) {
                    $this->getChildren($chilren, $count+=1);
                }
            }
        } else {
            foreach ($records as $user) {
                $this->result[] = array(
                    'name' => $user->name,
                    'email' => $user->email,
                    'upline' => $user->parent->email ?? NULL,
                    'first_leader' => $user->getLeaders()['first_leader'] ?? $user->getLeaders()['top_leader'],
                    'rank' => $user->rank->name,
                    'wallet' => $user->wallet_balance,
                    'personal_deposit' => number_format($user->personalDeposits(), 2),
                    'group_deposit' => number_format($user->groupTotalDeposit(), 2),
                    'downlines' => $user->getClientsCount(),
                    'level' => $count,
                );
                $chilren = $user->children;
                if (!$chilren->isEmpty()) {
                    $this->getChildren($chilren, $count+=1);
                }
            }
        }

        return collect($this->result);
    }

    public function getChildren($children, $count)
    {
        if ($this->not_admin) {
            foreach ($children as $child) {
                $this->result[] = array(
                    'name' => $child->name,
                    'email' => $child->email,
                    'rank' => $child->rank->name,
                    'wallet' => $child->wallet_balance,
                    'personal_deposit' => number_format($child->personalDeposits(), 2),
                    'group_deposit' => number_format($child->groupTotalDeposit(), 2),
                    'downlines' => $child->getClientsCount(),
                    'level' => $count,
                );
                $sub_children = $child->children;
                if (!$sub_children->isEmpty()) {
                    $this->getChildren($sub_children, $count+=1);
                }
            }
        } else {

            foreach ($children as $child) {
                $this->result[] = array(
                    'name' => $child->name,
                    'email' => $child->email,
                    'upline' => $child->parent->email ?? NULL,
                    'first_leader' => $child->getLeaders()['first_leader'] ?? $child->getLeaders()['top_leader'],
                    'rank' => $child->rank->name,
                    'wallet' => $child->wallet_balance,
                    'personal_deposit' => number_format($child->personalDeposits(), 2),
                    'group_deposit' => number_format($child->groupTotalDeposit(), 2),
                    'downlines' => $child->getClientsCount(),
                    'level' => $count,
                );
                $sub_children = $child->children;
                if (!$sub_children->isEmpty()) {
                    $this->getChildren($sub_children, $count+=1);
                }
            }
        }


    }

    public function headings(): array
    {
        if ($this->not_admin) {
            return [
                'User Name',
                'User Email',
                'User Rank',
                'Wallet Balance',
                'Personal Deposit',
                'Group Deposit',
                'Direct Downlines',
                'Level'
            ];
        } else {
            return [
                'User Name',
                'User Email',
                'Upline User Email',
                'First Leader',
                'User Rank',
                'Wallet Balance',
                'Personal Deposit',
                'Group Deposit',
                'Direct Downlines',
                'Level'
            ];
        }

    }
}
