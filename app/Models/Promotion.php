<?php

namespace App\Models;

use App\Jobs\SendPromotionToSubscriberJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes, HasFactory;
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
        'is_ongoing',
        'is_expired',
        'is_upcoming',
        'status',
        'status_color',
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
        return $this->start_date?->format('d.m.Y');
    }
    public function getFormattedEndDateAttribute()
    {
        return $this->end_date?->format('d.m.Y');
    }
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset("storage/{$this->image_path}") : null;
    }

    /**Filter
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $search
     * @param bool|null $trashed
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $search = null, $trashed = null)
    {
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }
        if ($trashed) {
            $query->onlyTrashed();
        } else {
            $query->whereNull('deleted_at');
        }
        return $query;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now());
    }
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }
    public function scopeOngoing($query)
    {
        return $query->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function scopeOrderByStartDate($query, $direction = 'asc')
    {
        return $query->orderBy('start_date', $direction);
    }

    public function getIsOngoingAttribute()
    {
        return $this->start_date <= now() && $this->end_date >= now();
    }
    public function getIsExpiredAttribute()
    {
        return $this->end_date < now();
    }
    public function getIsUpcomingAttribute()
    {
        return $this->start_date > now();
    }

    /**
     * Summary of getStatusAttribute
     * @return string
     */
    public function getStatusAttribute()
    {
        return match (true) {
            $this->is_ongoing => 'V teku',
            $this->is_expired => 'Potekla',
            $this->is_upcoming => 'Prihajajoča',
            default => 'Neznano',
        };
    }

    /**
     * Summary of getStatusColorAttribute
     * @return string
     */
    public function getStatusColorAttribute()
    {
        return match (true) {
            $this->is_ongoing => 'green',
            $this->is_expired => 'red',
            $this->is_upcoming => 'blue',
            default => 'gray',
        };
    }

    /*
     * Send the promotion to all active subscribers
     */
    public function sendToSubscribers()
    {
        // Assuming you have a method to send the promotion to subscribers
        // This is just a placeholder for the actual implementation
        $subscribers = Subscriber::active()->get();

        foreach ($subscribers as $subscriber) {
            $email = $subscriber->email;
            $unsubscribeUrl = route('subscribers.unsubscribe', ['email' => encrypt($email), 'token' => hash_hmac('sha256', $email, config('app.key'))]);
            // Send the promotion to the subscriber
            // You can use a notification or a mailer here
            SendPromotionToSubscriberJob::dispatch($this, $subscriber, $unsubscribeUrl);
        }
    }


}
