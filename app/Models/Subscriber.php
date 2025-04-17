<?php

namespace App\Models;

use App\Mail\MessageToSubscriber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Agent;

class Subscriber extends Model
{
    use HasFactory;
    // Define the attributes that are mass assignable
    protected $fillable = [
        'email',
        // 'is_subscribed',
        'ip_address',
        'user_agent',
    ];

    // Cast attributes to specific data types
    protected $casts = [
        'is_subscribed' => 'boolean',
    ];

    protected $appends = [
        'agent',
        'status_color',
    ];

    /**
     * Get the route key name for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'email';
    }

    /**
     * Apply filters to the query based on the provided filters array.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return void
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('email', 'like', '%' . $search . '%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'only') {
                $query->onlyTrashed();
            } elseif ($trashed === 'with') {
                $query->withTrashed();
            }
        });
    }

    /**
     * Scope active subscribers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_subscribed', true);
    }
    /**
     * Scope inactive subscribers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('is_subscribed', false);
    }

    /**
     * Scope a query to only include subscribed users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubscribed($query)
    {
        return $query->where('is_subscribed', true);
    }

    /**
     * Scope a query to only include unsubscribed users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnsubscribed($query)
    {
        return $query->where('is_subscribed', false);
    }

    /**
     * Accessor to get the agent details as an object.
     *
     * This method uses the `createAgent` method to create an instance of the Agent class
     * and retrieves details about the user's device, platform, and browser.
     *
     * @return object
     */
    public function getAgentAttribute()
    {
        // Check if the agent details are already cached
        return cache()->rememberForever("subscriber_agent_{$this->id}", function () {
            // Create an instance of the Agent class using the user agent string
            $agent = $this->createAgent();

            // Return an object containing agent details
            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(), // Check if the user is on a desktop
                    'platform' => $agent->platform(),   // Get the platform (e.g., Windows, macOS)
                    'browser' => $agent->browser(),     // Get the browser name (e.g., Chrome, Firefox)
                ],
            ];
        });
    }

    public function getStatusColorAttribute()
    {
        return $this->is_subscribed ? 'green' : 'red';
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Laravel\Jetstream\Agent
     */
    protected function createAgent()
    {
        return tap(new Agent(), fn($agent) => $agent->setUserAgent($this->user_agent));
    }

    /**
     * Send message
     *
     *
     * */
    public function sendMessage($message, $unsubscribeUrl = null)
    {
        // Check if the subscriber is active
        if (!$this->is_subscribed) {
            return;
        }

        // Send the message to the subscriber
        Mail::to($this->email)->send(new MessageToSubscriber($message, $this, $unsubscribeUrl));
    }
}
