<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:clients,email'
                . ($this->client ? ',' . $this->client->id : null),
            'avatar' => [
                Rule::requiredIf(fn(): bool => empty($this->client->avatar)),
                'image',
                'dimensions:min_width=100,min_height=100'
            ]
        ];
    }
}
