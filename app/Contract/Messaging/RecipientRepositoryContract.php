<?php

namespace App\Contract\Messaging;


use App\Models\Recipient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RecipientRepositoryContract
{
    /**
     * @param string $isSent
     * @param int $limit
     * @param array $columns
     * @return Collection
     */
    public function getBySent(string $isSent, int $limit, array $columns = ['*']): Collection;

    /**
     * @param int $id
     * @param bool $isSent
     * @return Recipient
     */
    public function findOneByIdAndSent(int $id, bool $isSent): Recipient;

    /**
     * @param array<int> $ids
     * @return bool
     */
    public function updateAllAsSent(array $ids): bool;

    /**
     * @param bool $isSent
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAsPaginatedBySent(bool $isSent, int $perPage = 25): LengthAwarePaginator;

    /**
     * @param array $values
     * @return bool
     */
    public function createSentMessages(array $values): bool;
}
