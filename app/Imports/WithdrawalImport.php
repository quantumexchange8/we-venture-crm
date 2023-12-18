<?php

namespace App\Imports;

use App\Models\Deposits;
use App\Models\Settings;
use App\Models\User;
use App\Models\Withdrawals;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class WithdrawalImport implements ToCollection, WithHeadingRow, withValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $key=>$row) {

            $user = User::where('email', $row['email'])->withTrashed()->first();
            $perform_action = true;
            $msg = null;


            $settings = Settings::getKeyValue();
            $amount = round( $row['amount'], 2);
            $fee = $settings['withdrawal_transaction_fee'];

            if ($amount - $fee <= 0)
            {
                $perform_action = false;
                $msg = [trans('public.invalid_action') . ', ' . trans('public.unnecessary_withdraw')];
            } elseif ($row['status'] == Withdrawals::STATUS_APPROVED && $amount > $user->wallet_balance) {
                $perform_action = false;
                $msg = [trans('public.invalid_action') . ', ' . trans('public.insufficient_amount')];
            }

            if ($perform_action) {
                $withdrawal = Withdrawals::create([
                    'network' => $row['network'],
                    'amount' => round($amount - $fee, 2),
                    'address' => $row['address'],
                    'transaction_fee' => $fee,
                    'status' => $row['status'],
                    'requested_by_user' => $user->id,
                ]);
                if ($withdrawal->status == Withdrawals::STATUS_APPROVED) {

                    $user->wallet_balance  = $user->wallet_balance - $withdrawal->amount - $withdrawal->transaction_fee;
                    $user->save();
                }
            } else {
                $failures[] = new Failure($key+2, 'amount', $msg , $row->toArray());
                $this->failures = array_merge($this->failures, $failures);
            }
        }
    }


    public function rules(): array
    {

        return [
            'email' => 'required|email|exists:users,email',
            'address' => 'required',
            'network' =>  ['required', Rule::in([Withdrawals::TRC20, Withdrawals::ERC20, Withdrawals::BEP20])],
            'amount' => ['required', 'numeric',],
            'status' =>  ['required', Rule::in([Withdrawals::STATUS_PENDING, Withdrawals::STATUS_APPROVED, Withdrawals::STATUS_REJECTED])],
        ];
    }

    public function customValidationAttributes(): array
    {
        return [
            'email' => trans('public.email'),
            'address' => trans('public.address'),
            'network' => trans('public.method'),
            'amount' => trans('public.amount'),
            'status' => trans('public.status'),
        ];
    }

    public function customValidationMessages()
    {
        return [

        ];
    }

    public function onFailure(Failure ...$failures)
    {
        $this->failures = array_merge($this->failures, $failures);
    }

    public function failures()
    {
        return $this->failures;
    }
}
