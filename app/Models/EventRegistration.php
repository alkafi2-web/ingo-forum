<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_id',
        'member_id',
        'attendee_name',        // Updated from 'representive_name'
        'attendee_email',       // Updated from 'representive_email'
        'attendee_phone',       // Updated from 'representive_phone'
        'guest_info',
        'total_participant',
        'reg_fees_status',      // Updated with new default value
        'reg_fees',             // New attribute
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
