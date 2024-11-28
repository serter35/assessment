<?php

namespace App\Contract\Messaging;

use App\Models\Recipient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RecipientServiceContract
{
    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAsPaginatedBySent(int $perPage = 25): LengthAwarePaginator;

    /**
     * @param int $id
     * @return Recipient
     */
    public function findRecipientAsSent(int $id): Recipient;

    /**
     * @param int $limit
     * @return Collection<Recipient>
     */
    public function getPendingRecipients(int $limit): Collection;

    /**
     * @param array $recipientIds
     * @return bool
     */
    public function markAllAsSent(array $recipientIds): bool;

    /**
     * @param array $values
     * @return bool
     */
    public function createManySentMessages(array $values): bool;

    /**
     * @param Collection $recipients
     * @return Collection
     */
    public function sendMessageToRecipients(Collection $recipients): Collection;
}
