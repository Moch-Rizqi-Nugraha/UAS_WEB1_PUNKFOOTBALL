<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Event::select('id', 'name', 'description', 'event_date', 'location', 'category', 'status', 'price', 'max_participants', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Event Date',
            'Location',
            'Category',
            'Status',
            'Price',
            'Max Participants',
            'Created At',
        ];
    }
}
