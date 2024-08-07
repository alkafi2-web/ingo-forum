<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by'); // Assuming 'added_by' is the foreign key in your posts table
    }
    public function addedBy_member()
    {
        return $this->belongsTo(MemberInfo::class, 'member_id','member_id'); // Assuming 'added_by' is the foreign key in your posts table
    }

    public function category()
    {
        return $this->belongsTo(PublicationCategory::class);
    }
}
