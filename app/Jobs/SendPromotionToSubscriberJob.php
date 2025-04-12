<?php

namespace App\Jobs;

use App\Models\Promotion;
use App\Models\Subscriber;
use App\Mail\PromotionEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPromotionToSubscriberJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $promotion;
    public $subscriber;

    /**
     * Create a new job instance.
     */
    public function __construct(Promotion $promotion, Subscriber $subscriber)
    {
        $this->promotion = $promotion;
        $this->subscriber = $subscriber;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send the promotion email to the subscriber
        Mail::to($this->subscriber->email)->send(new PromotionEmail($this->promotion, $this->subscriber));
    }
}
