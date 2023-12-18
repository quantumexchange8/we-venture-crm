<?php

namespace App\Imports;


namespace App\Imports;

use App\Models\Brokers;
use App\Models\Commissions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CommissionsImport implements ToCollection, WithHeadingRow, withValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    private $brokerId;
    private $pammId;

    public function __construct($brokerId, $pammId)
    {
        $this->brokerId = $brokerId;
        $this->pammId = $pammId;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            $user = User::where('email', $row['email'])->withTrashed()->first();
            $transactionDate = Carbon::instance(Date::excelToDateTimeObject($row['transaction_date']))->format('Y-m-d H:i:s');
            Commissions::create([
                'lot_size' => round($row['lot_size'], 2),
                'transaction_at' => $transactionDate,
                'user_rankId' =>  $user->rank->id,
                'userId' => $user->id,
                'brokersId' => $this->brokerId,
                'pamm_id' => $this->pammId,
            ]);
        }
    }


    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'transaction_date' => 'required|regex:/[0-9]+[.]?[0-9]*/|',
            'lot_size' => 'required|numeric',
        ];
    }

    public function customValidationAttributes(): array
    {
        return [
            'email' => trans('public.email'),
            'transaction_date' => trans('public.transaction_date'),
            'lot_size' => trans('public.lot_size'),
        ];
    }

    public function customValidationMessages()
    {
        return [
            'transaction_date.required' => trans('public.transaction_date_required'),
            'transaction_date.regex' => trans('public.transaction_date_regex'),
            'lot_size.required' => trans('public.lot_size_required'),
            'lot_size.numeric' => trans('public.lot_size_numeric'),
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
