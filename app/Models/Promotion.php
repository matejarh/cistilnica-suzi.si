<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'image_path',
        'is_active',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    protected $appends = [
        'formatted_start_date',
        'formatted_end_date',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $attributes = [
        'is_active' => true,
    ];
    public function getFormattedStartDateAttribute()
    {
        return $this->start_date ? $this->start_date->format('d.m.Y') : null;
    }
    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? $this->end_date->format('d.m.Y') : null;
    }
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }


}
