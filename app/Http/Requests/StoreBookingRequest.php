<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'flight_index' => ['required'],

            'passengers' => ['required', 'array', 'min:1'],

            'passengers.*.first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u'
            ],

            'passengers.*.last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u'
            ],

            'passengers.*.birth_date' => [
                'required',
                'date',
                'before:today'
            ],

            'passengers.*.nationality' => [
                'required',
                'string',
                'max:100',
                'regex:/^[\pL\s]+$/u'
            ],

            'passengers.*.document_number' => [
                'required',
                'string',
                'max:50',
                'alpha_num'
            ],

            'passengers.*.passenger_type' => [
                'required',
                'in:adult,child,infant'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'flight_index.required' => 'Flight selection is missing.',

            'passengers.required' => 'At least one passenger is required.',
            'passengers.array' => 'Passengers data is invalid.',
            'passengers.min' => 'At least one passenger is required.',

            'passengers.*.first_name.required' => 'First name is required.',
            'passengers.*.first_name.regex' => 'First name can only contain letters.',

            'passengers.*.last_name.required' => 'Last name is required.',
            'passengers.*.last_name.regex' => 'Last name can only contain letters.',

            'passengers.*.birth_date.required' => 'Birth date is required.',
            'passengers.*.birth_date.date' => 'Birth date must be a valid date.',
            'passengers.*.birth_date.before' => 'Birth date must be in the past.',

            'passengers.*.nationality.required' => 'Nationality is required.',
            'passengers.*.nationality.regex' => 'Nationality can only contain letters.',

            'passengers.*.document_number.required' => 'Document number is required.',
            'passengers.*.document_number.alpha_num' => 'Document number must be alphanumeric.',

            'passengers.*.passenger_type.required' => 'Passenger type is required.',
            'passengers.*.passenger_type.in' => 'Invalid passenger type selected.',
        ];
    }
}
