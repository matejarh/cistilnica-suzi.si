<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    // Define the attributes that are mass assignable
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'ip',
        'user_agent',
        'status',
    ];

    // Cast attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Set default attribute values
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Accessor for the "status" attribute.
     * Converts the status value into a human-readable format.
     *
     * @param string $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return $value === 'pending' ? 'V obdelavi' : ($value === 'answered' ? 'Odgovorjeno' : 'Zaključeno');
    }

    /**
     * Scope to filter inquiries based on provided filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, array $filters)
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        });
    }

    /**
     * Scope to include only trashed (soft-deleted) inquiries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTrashed($query)
    {
        return $query->onlyTrashed();
    }

    /**
     * Scope to include only non-trashed inquiries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNonTrashed($query)
    {
        return $query->withoutTrashed();
    }

    /**
     * Scope to include only answered inquiries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAnswered($query)
    {
        return $query->where('status', 'answered');
    }

    /**
     * Scope to include only closed inquiries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Scope to include only pending inquiries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to include inquiries with a specific status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to include inquiries created within the last 30 days.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', now()->subDays(30));
    }

    /**
     * Scope to include inquiries created within the last 7 days.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastWeek($query)
    {
        return $query->where('created_at', '>=', now()->subDays(7));
    }

    /**
     * Scope to include inquiries created today.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now());
    }
}
