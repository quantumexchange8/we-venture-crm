<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

//    public function messages()
//    {
//        return [
//
//        ];
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|regex:/^[a-zA-Z0-9\p{Han}. ]+$/u|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'string', 'confirmed',
                Password::min(6)->letters()->numbers()],
            'phone' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $cleanedPhone = str_replace(' ', '', $value);
                    $count = User::where('contact_number', $cleanedPhone)->count();
                    if ($count > 0) {
                        $fail(trans('validation.unique', [$attribute]));
                    }
                }
            ],
            'address' => 'string|required|max:255',
            'country' => 'required|string',
            'referral' => 'nullable|exists:users,referral_id',
//            'tnc_check' => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => trans('public.name'),
            'phone' => trans('public.contact'),
            'email' => trans('public.email'),
            'password' => trans('public.password'),
            'address' => trans('public.address'),
            'country' => trans('public.country'),
            'referral' => trans('public.referral_code'),
//            'tnc_check' => trans('public.tnc_check'),
        ];
    }
}
