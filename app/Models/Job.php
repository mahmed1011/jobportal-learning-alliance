<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $casts = [
        'posted_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'slug',
        'department_id',
        'employment_type_id',
        'campus_ids',
        'description',
        'status',
        'posted_at',
        'expires_at',
        'created_by',
    ];

    // Relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}
