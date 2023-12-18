<?php

namespace App\Http\Requests;

use App\Models\Settings;
use App\Models\Withdrawals;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWithdrawalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'network' => ['required', Rule::in(Withdrawals::$walletTypes)],
            'address' => 'required',
            'amount' => 'required|numeric',
        ];
    }
}
