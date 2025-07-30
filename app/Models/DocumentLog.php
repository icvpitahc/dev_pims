<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'status_type_id',
        'action_id',
        'from_division_id',
        'to_division_id',
        'remarks',
        'created_by',
        'updated_by',
    ];

    public function toDivision()
    {
        return $this->belongsTo(Division::class, 'to_division_id');
    }

    public function fromDivision()
    {
        return $this->belongsTo(Division::class, 'from_division_id');
    }

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
