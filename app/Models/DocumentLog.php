<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class DocumentLog extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'document_id',
        'status_type_id',
        'action_id',
        'from_division_id',
        'to_division_id',
        'remarks',
        'created_by',
        'updated_by',
        'received_date',
        'received_by',
        'forwarded_date',
        'forwarded_by',
        'deleted_by',
    ];

    protected $casts = [
        'received_date' => 'datetime',
        'forwarded_date' => 'datetime',
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

    public function userReceived()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function userForwarded()
    {
        return $this->belongsTo(User::class, 'forwarded_by');
    }
}
