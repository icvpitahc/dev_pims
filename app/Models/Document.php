<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_reference_code',
        'document_type_id',
        'document_sub_type_id',
        'document_title',
        'specify_attachments',
        'note',
        'division_id',
        'created_by',
    ];

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function document_sub_type()
    {
        return $this->belongsTo(DocumentSubType::class);
    }

    public function user_created()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user_updated()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function logs()
    {
        return $this->hasMany(DocumentLog::class);
    }

    public function latestLog()
    {
        return $this->hasOne(DocumentLog::class)->latestOfMany();
    }

    public function latestActiveLog()
    {
        return $this->hasOne(DocumentLog::class)->where('status_type_id', 1)->latestOfMany();
    }

    public function getCurrentLocationAttribute()
    {
        return $this->latestActiveLog->toDivision->division_name ?? 'N/A';
    }

    public function getStatusAttribute()
    {
        $user = auth()->user();

        if ($this->latestLog) {
            if ($this->latestLog->action_id == 3) {
                return 'Completed';
            }

            if ($this->latestLog->action_id == 2) {
                return 'Discarded';
            }

            if ($this->latestActiveLog && $this->latestActiveLog->to_division_id == $user->division_id) {
                return 'Pending';
            }
        }

        if ($this->created_by == $user->id || $this->division_id == $user->division_id) {
            return 'Ongoing';
        }

        return 'N/A';
    }
}
