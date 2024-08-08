<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'details',
        'media',
        'start_date',
        'end_date',
        'location',
        'type',
        'reg_dead_line',
        'ref_fees',
        'status',
        'reg_enable_status',
        'capacity',
        'creator_type',
        'creator_id',
        'approval_status',
        'approval_status_changed_by'
    ];
    
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'reg_dead_line' => 'datetime',
    ];

    public function participants()
    {
        return $this->hasMany(EventRegistration::class);
    }
    
    public function creator()
    {
        return $this->morphTo(null, 'creator_type', 'creator_id');
    }
    
}
