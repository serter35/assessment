<?php

namespace App\Services\Messaging;

use App\Contract\Messaging\ClientContract;
use App\Contract\Messaging\RecipientRepositoryContract;
use App\Contract\Messaging\RecipientServiceContract;
use App\DTOs\Messaging\ClientRecipient;
use App\Models\Recipient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

readonly class RecipientService implements RecipientServiceContract
{
    public function __construct(
        private RecipientRepositoryContract $repository,
        private ClientContract $client
    )
    {
    }

    public function getAsPaginatedBySent(int $perPage = 25): LengthAwarePaginator
    {
        return $this->repository->getAsPaginatedBySent(true, $perPage);
    }

    public function findRecipientAsSent(int $id): Recipient
    {
        return $this->repository->findOneByIdAndSent($id, true);
    }

    public function getPendingRecipients($limit): Collection
    {
        return $this->repository->getBySent(false, $limit);
    }

    public function markAllAsSent(array $recipientIds): bool
    {
        return $this->repository->updateAllAsSent($recipientIds);
    }

    public function createManySentMessages(array $values): bool
    {
        return $this->repository->createSentMessages($values);
    }

    public function sendMessageToRecipients(Collection $recipients): Collection
    {
        return $recipients->map(function (Recipient $recipient) {
            $response = $this->client->send(ClientRecipient::fromModel($recipient));

            Cache::set('messaging: ' . $recipient->id, $response);

            return [
                'recipient_id' => $recipient->id,
                'message_id' => $response->messageId,
                'sent_at' => $response->sentAt,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });
    }
}
