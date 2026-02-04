<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'event_date' => ['required', 'date', 'after:today'],
            'location' => ['required', 'string', 'max:100'],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'status' => ['required', Rule::in(['active', 'cancelled', 'completed'])],
            'max_participants' => ['required', 'integer', 'min:1', 'max:10000'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Event name is required',
            'name.max' => 'Event name cannot exceed 100 characters',
            'description.required' => 'Event description is required',
            'description.max' => 'Description cannot exceed 1000 characters',
            'event_date.required' => 'Event date is required',
            'event_date.date' => 'Event date must be a valid date',
            'event_date.after' => 'Event date must be in the future',
            'location.required' => 'Location is required',
            'location.max' => 'Location cannot exceed 100 characters',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Selected category does not exist',
            'status.required' => 'Status is required',
            'status.in' => 'Status must be: active, cancelled, or completed',
            'max_participants.required' => 'Maximum participants is required',
            'max_participants.integer' => 'Maximum participants must be a number',
            'max_participants.min' => 'Must allow at least 1 participant',
            'max_participants.max' => 'Cannot exceed 10000 participants',
        ];
    }
}
