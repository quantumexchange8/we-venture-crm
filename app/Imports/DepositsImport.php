<?php

namespace App\Imports;

use App\Models\Brokers;
use App\Models\Deposits;
use App\Models\Pamm;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DepositsImport implements ToCollection, WithHeadingRow, withValidation, SkipsOnError, SkipsOnFailure
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
        foreach ($rows as $key=>$row) {

            $user = User::where('email', $row['email'])->withTrashed()->first();
            $transactionDate = Carbon::instance(Date::excelToDateTimeObject($row['transaction_date']))->format('Y-m-d H:i:s');
            $perform_action = true;
            $type = Deposits::TYPE_DEPOSIT;

            if ($row['type'] == Deposits::TYPE_WITHDRAW) {
                $capital_available_in_broker = $user->withdrawalAmountValidationByBrokers($this->brokerId, $this->pammId)->first();
                $capital_available_in_broker = $capital_available_in_broker->amount ?? 0;
                $type = Deposits::TYPE_WITHDRAW;
                if ($row['amount'] > $capital_available_in_broker) {
                    $perform_action = false;
                    $failures[] = new Failure($key+2, 'amount', [trans('public.invalid_action') . ', ' . trans('public.insufficient_amount')], $row->toArray());
                    $this->failures = array_merge($this->failures, $failures);
                }
            }
            if ($perform_action) {
                Deposits::create([
                    'amount' => round($row['amount'], 2),
                    'transaction_at' => $transactionDate,
                    'userId' => $user->id,
                    'brokersId' =>  $this->brokerId,
                    'pamm_id' =>  $this->pammId,
                    'remarks' =>  $row['remarks'],
                    'type' => $type,
                ]);

                if ($user->email_status == 1 && $user->email_sent == 0) {
                    $data['email'] = $user->email;
                    $data['title'] = 'Important Information Regarding Your Investment with Clark Well Capital 关于您在汇佳资本的投资的重要信息';

                    $html = view('admin.member.acknowledgement_pdf', ['user' => $user])->render();

                    $pdf = PDF::loadHTML($html);
                    $pdfContent = $pdf->output();

                    Mail::send('email', ['user' => $user], function ($message) use ($data, $pdfContent, $user) {
                        $message->to($data['email'])
                            ->subject($data['title'])
                            ->attachData($pdfContent, $user->name . '.pdf');
                    });

                    $user->update([
                        'email_sent' => 1
                    ]);
                }
            }
        }
    }


    public function rules(): array
    {

        return [
            'email' => 'required|email|exists:users,email',
            'transaction_date' => 'required|regex:/[0-9]+[.]?[0-9]*/|',
            'type' =>  ['required', Rule::in([Deposits::TYPE_DEPOSIT, Deposits::TYPE_WITHDRAW])],
            'amount' => ['required', 'numeric'],
        ];
    }

    public function customValidationAttributes(): array
    {
        return [
            'email' => trans('public.email'),
            'transaction_date' => trans('public.transaction_date'),
            'type' => trans('public.method'),
            'amount' => trans('public.amount'),
        ];
    }


    public function customValidationMessages()
    {
        return [
            'transaction_date.required' => trans('public.transaction_date_required'),
            'transaction_date.regex' => trans('public.transaction_date_regex'),
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
