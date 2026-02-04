<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules()
    {
        return [
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'ticket_id' => ['required', 'integer', Rule::exists('tickets', 'id')],
            'product_id' => ['nullable', 'integer', Rule::exists('products', 'id')],
            'amount' => ['required', 'numeric', 'min:0'],
            'transaction_date' => ['required', 'date'],
            'status' => ['required', Rule::in(['pending', 'completed', 'failed', 'refunded'])],
            'payment_method' => ['required', Rule::in(['bank_transfer', 'credit_card', 'e_wallet', 'cash'])],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User is required',
            'user_id.exists' => 'Selected user does not exist',
            'ticket_id.required' => 'Ticket is required',
            'ticket_id.exists' => 'Selected ticket does not exist',
            'product_id.exists' => 'Selected product does not exist',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a valid number',
            'amount.min' => 'Amount must be at least 0',
            'transaction_date.required' => 'Transaction date is required',
            'transaction_date.date' => 'Transaction date must be a valid date',
            'status.required' => 'Status is required',
            'status.in' => 'Status must be: pending, completed, failed, or refunded',
            'payment_method.required' => 'Payment method is required',
            'payment_method.in' => 'Payment method must be: bank_transfer, credit_card, e_wallet, or cash',
        ];
    }
}
