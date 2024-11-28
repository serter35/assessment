<?php

namespace App\Repositories;

use App\Contract\Messaging\RecipientRepositoryContract;
use App\Models\Recipient;
use App\Models\RecipientSentMessage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RecipientRepository implements RecipientRepositoryContract
{
    public function getBySent(string $isSent, int $limit, array $columns = ['*']): Collection
    {
        return Recipient::whereSent($isSent)->select($columns)->take($limit)->get();
    }

    public function findOneByIdAndSent(int $id, bool $isSent): Recipient
    {
        return Recipient::whereIdAndSent($id, $isSent)->firstOrFail();
    }

    public function updateAllAsSent(array $ids): bool
    {
        return Recipient::whereIn('id', $ids)->update(['sent' => true]);
    }

    public function getAsPaginatedBySent(bool $isSent, int $perPage = 25): LengthAwarePaginator
    {
        return Recipient::whereSent($isSent)->paginate($perPage);
    }

    public function createSentMessages(array $values): bool
    {
        return RecipientSentMessage::insert($values);
    }
}
