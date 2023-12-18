<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrokerRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'note' => 'required',
            'url' => 'required|url',
            'broker_image' => 'required|image|dimensions:width=200,height=200',
            'qr_image' => 'required|image|dimensions:max_width=512,max_height=256',
        ];
    }

    public function messages()
    {
        return [
            // 'name.required' => 'The first name field is required.',
            'broker_image.dimensions' => 'The broker image required image with 200x200 pixels.',
            'qr_image.display_length' => 'The maximum dimensions of qr_image is 512x256 pixels',
        ];
    }
}
