<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrokerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'note' => 'required',
            'url' => 'required|url',
            'broker_image' => 'nullable|image|dimensions:width=200,height=200',
            'qr_image' => 'nullable|image|dimensions:max_width=512,max_height=256',
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
