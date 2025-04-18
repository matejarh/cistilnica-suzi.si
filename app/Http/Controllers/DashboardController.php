<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Promotion;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard view.
     *
     */
    public function show()
    {
        return inertia('Dashboard', [
            'unanswered_inquiries' => Inquiry::pending()->latest()->get(),
            'ongoing_promotions' => Promotion::ongoing()->latest()->take(5)->get(),
            'new_subscribers' => Subscriber::latest()->take(5)->get(),
        ]);
    }
}
