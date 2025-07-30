<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable, MustVerifyEmail
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'email',
        'local',
        'password',
        'position_id',
        'office_id',
        'division_id',
        'userlevel_id',
        'status_type_id',
        'updated_by',
    ];

    protected $auditInclude = [
        'last_name',
        'first_name',
        'middle_name',
        'email',
        'local',
        'password',
        'position_id',
        'office_id',
        'division_id',
        'userlevel_id',
        'status_type_id',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id')->orderBy('id', 'asc');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id')->orderBy('id', 'asc');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id')->orderBy('id', 'asc');
    }

    public function userlevel()
    {
        return $this->belongsTo(Userlevel::class, 'userlevel_id')->orderBy('id', 'asc');
    }

    public function status_type()
    {
        return $this->belongsTo(StatusType::class, 'status_type_id')->orderBy('id', 'asc');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by')->orderBy('id', 'asc');
    }


    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->Where('last_name', 'like', $term)
                ->orWhere('email', 'like', $term)
                ->orWhereHas('office', function ($query) use ($term) {
                    $query->where('office_name', 'like', $term);
                })
                ->orWhereHas('division', function ($query) use ($term) {
                    $query->where('division_name', 'like', $term);
                })
                ->orWhereHas('userlevel', function ($query) use ($term) {
                    $query->where('userlevel_name', 'like', $term);
                })
                ->orWhereHas('status_type', function ($query) use ($term) {
                    $query->where('status_type_name', 'like', $term);
                })
                ->orWhereHas('updated_by', function ($query) use ($term) {
                    $query->where('last_name', 'like', $term);
                });
        });
    }

    public function getSignatureNameAttribute()
    {
        $firstNameInitials = '';
        if ($this->first_name) {
            $names = explode(' ', $this->first_name);
            foreach ($names as $name) {
                $firstNameInitials .= strtoupper(substr($name, 0, 1));
            }
        }

        $middleNameInitial = '';
        if ($this->middle_name) {
            $middleNameInitial = strtoupper(substr($this->middle_name, 0, 1));
        }

        return $firstNameInitials . $middleNameInitial . ucfirst(strtolower($this->last_name));
    }
}
