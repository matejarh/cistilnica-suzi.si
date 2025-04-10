<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'is_subscribed',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_subscribed' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'email';
    }


}
