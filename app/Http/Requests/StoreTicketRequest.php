<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()?->isAdmin();
    }

    public function rules()
    {
        return [
            'event_id' => ['required', 'exists:events,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ];
    }

    public function messages()
    {
        return [
            'event_id.required' => 'Please select an event',
            'event_id.exists' => 'The selected event does not exist',
            'quantity.required' => 'Quantity is required',
            'quantity.min' => 'Quantity must be at least 1',
            'quantity.max' => 'Cannot create more than 100 tickets at once',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a valid number',
            'price.min' => 'Price cannot be negative',
        ];
    }

    public function validated($key = null, $default = null)
    {
        return parent::validated($key, $default);
    }
}
