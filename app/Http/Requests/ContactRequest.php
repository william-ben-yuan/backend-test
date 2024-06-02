<?php

namespace App\Http\Requests;

use App\Enums\ContactTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
                Rule::in(ContactTypeEnum::cases()),
            ],
            'contact' => 'required|string|max:255',
        ];
    }
}
