<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Document extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'document_reference_code',
        'document_type_id',
        'document_sub_type_id',
        'document_title',
        'specify_attachments',
        'note',
        'division_id',
        'created_by',
        'deleted_by',
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
        $log = $this->latestActiveLog ?? $this->latestLog;

        if ($log) {
            if ($log->toDivision) {
                return $log->toDivision->division_name;
            }
            return $log->fromDivision->division_name;
        }

        return 'N/A';
    }

    public function getStatusAttribute()
    {
        if ($this->latestLog) {
            if ($this->latestLog->action_id == 3) {
                return 'Completed';
            }

            if ($this->latestLog->action_id == 2) {
                return 'Discarded';
            }

            if (auth()->check()) {
                $user = auth()->user();
                if ($this->latestActiveLog && $this->latestActiveLog->to_division_id == $user->division_id) {
                    return 'Pending';
                }
            }
        }

        // If none of the above, it's Ongoing
        return 'Ongoing';
    }

    public function isPendingReception()
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        $activeLog = $this->latestActiveLog;

        return $activeLog &&
               $activeLog->to_division_id == $user->division_id &&
               is_null($activeLog->received_date);
    }

    public function isReadyForAction()
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        $activeLog = $this->latestActiveLog;

        return $activeLog &&
               $activeLog->from_division_id == $user->division_id &&
               is_null($activeLog->action_id);
    }

    protected static function booted()
    {
        static::deleting(function ($document) {
            if ($document->isForceDeleting()) {
                $document->logs()->forceDelete();
            } else {
                $document->logs->each(function ($log) use ($document) {
                    $log->update(['deleted_by' => $document->deleted_by]);
                    $log->delete();
                });
            }
        });
    }
}
