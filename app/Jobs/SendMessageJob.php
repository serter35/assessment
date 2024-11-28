<?php

namespace App\Jobs;

use App\Contract\Messaging\ClientContract;
use App\Contract\Messaging\RecipientServiceContract;
use App\DTOs\Messaging\ClientRecipient;
use App\Models\Recipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $sendingCount)
    {
        //
    }

    /**
     * Belirtilen adede göre Mesaj gönderimi yapılır.
     * Gönderim yapılan alıcılar Redis'de depolanır.
     * Tüm gönderim yapılan alıcılar toplu(bulk) şekilde veritabanında işaretlenir.
     */
    public function handle(RecipientServiceContract $service): void
    {
        $recipients = $service->getPendingRecipients($this->sendingCount);
        $sentRecipients = $service->sendMessageToRecipients($recipients);

        DB::transaction(function () use ($service, $sentRecipients) {
            $service->markAllAsSent($sentRecipients->pluck('recipient_id')->toArray());

            $service->createManySentMessages($sentRecipients->toArray());
        });
    }
}
