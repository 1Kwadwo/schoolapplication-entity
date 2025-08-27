<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'tuition_fee',
        'capacity',
        'is_active',
    ];

    protected $casts = [
        'tuition_fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function getActiveApplicationsCountAttribute()
    {
        return $this->applications()->whereIn('status', ['pending', 'under_review', 'accepted'])->count();
    }

    public function getIsFullAttribute()
    {
        if (!$this->capacity) return false;
        return $this->active_applications_count >= $this->capacity;
    }

    public function getAvailableSpotsAttribute()
    {
        if (!$this->capacity) return null;
        return max(0, $this->capacity - $this->active_applications_count);
    }
}
