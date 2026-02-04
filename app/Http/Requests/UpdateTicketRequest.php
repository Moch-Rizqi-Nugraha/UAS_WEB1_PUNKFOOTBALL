<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules()
    {
        return [
            'ticket_number' => ['required', 'string', 'max:50', Rule::unique('tickets')->ignore($this->ticket)],
            'event_id' => ['required', 'integer', Rule::exists('events', 'id')],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:1', 'max:1000'],
            'status' => ['required', Rule::in(['available', 'used', 'cancelled', 'expired'])],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages()
    {
        return [
            'ticket_number.required' => 'Ticket number is required',
            'ticket_number.unique' => 'This ticket number already exists',
            'event_id.required' => 'Event is required',
            'event_id.exists' => 'Selected event does not exist',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a valid number',
            'price.min' => 'Price must be at least 0',
            'quantity.required' => 'Quantity is required',
            'quantity.integer' => 'Quantity must be a whole number',
            'quantity.min' => 'Quantity must be at least 1',
            'quantity.max' => 'Quantity cannot exceed 1000',
            'status.required' => 'Status is required',
            'status.in' => 'Status must be one of: available, used, cancelled, expired',
        ];
    }
}
