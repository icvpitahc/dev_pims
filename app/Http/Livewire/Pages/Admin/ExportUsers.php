<?php

namespace App\Http\Livewire\Pages\Admin;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUsers implements FromCollection, WithHeadings
{
    protected $selected;

    public function __construct($selected)
    {
        $this->selected = $selected;
    }

    public function collection()
    {
        return User::whereIn('id', $this->selected)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Email Verified At',
            'Created At',
            'Updated At',
            'Status Type ID',
            'User Level ID',
            'Division ID',
            'Transacting Office ID',
        ];
    }
}
