<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\Agent;

class Subscriber extends Model
{
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
        });
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
}
