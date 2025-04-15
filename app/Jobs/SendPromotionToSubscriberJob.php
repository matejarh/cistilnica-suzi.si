<?php

namespace App\Jobs;

use App\Models\Promotion;
use App\Models\Subscriber;
use App\Mail\PromotionEmail;

use DragonCode\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPromotionToSubscriberJob implements ShouldQueue, ShouldBeUnique {
    use Dispatchable, InteractsWithQueue, SerializesModels;
    public $promotion;
    public $subscriber;
    public $unsubscribeUrl;

    /**
     * Create a new job instance.
     */
    public function __construct(Promotion $promotion, Subscriber $subscriber, string $unsubscribeUrl = null)
    {
        $this->promotion = $promotion;
        $this->subscriber = $subscriber;
        $this->unsubscribeUrl = $unsubscribeUrl;
    }

    /**
     * Get the unique identifier for the job.
     */
    public function uniqueId(): string
    {
        return $this->subscriber->id;
    }

    /**
     * Get the time (in seconds) for which the job should remain unique.
     */
    public function uniqueFor(): int
    {
        return 3600; // 1 hour
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
            Mail::to($this->subscriber->email)->send(new PromotionEmail($this->promotion, $this->subscriber, $this->unsubscribeUrl));

    }

    /**
     * Handle job failure.
     */
    public function failed(\Throwable $exception): void
    {
        // Handle the failure, e.g., log the error or notify someone
        \Log::error('Failed to send promotion email to subscriber: ' . $this->subscriber->email, [
            'error' => $exception->getMessage(),
            'promotion' => $this->promotion,
            'subscriber' => $this->subscriber,
        ]);
    }
}
