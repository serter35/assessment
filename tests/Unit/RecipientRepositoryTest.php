<?php

use App\Contract\Messaging\RecipientRepositoryContract;
use App\Models\Recipient;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    // RecipientRepositoryContract'ı mock'luyoruz
    $this->mockRepository = mock(RecipientRepositoryContract::class);
});

it('can find recipient by id and sent status', function () {
    $recipient = Recipient::factory()->create(['sent' => true]);

    $this->mockRepository
        ->shouldReceive('findOneByIdAndSent')
        ->with($recipient->id, true)
        ->andReturn($recipient);

    $result = $this->mockRepository->findOneByIdAndSent($recipient->id, true);

    $this->assertEquals($recipient->id, $result->id);
    $this->assertEquals(true, $result->sent);
});

it('can update all recipients as sent', function () {
    $recipients = Recipient::factory()->count(5)->create();

    $recipientIds = $recipients->pluck('id')->toArray();

    $this->mockRepository
        ->shouldReceive('updateAllAsSent')
        ->with($recipientIds)
        ->andReturn(true);

    $result = $this->mockRepository->updateAllAsSent($recipientIds);

    $this->assertTrue($result);
});

it('can get recipients by sent status', function () {
    $recipients = Recipient::factory()->count(5)->make(['sent' => true]);

    $this->mockRepository
        ->shouldReceive('getBySent')
        ->with('true', 5)
        ->andReturn($recipients);

    $result = $this->mockRepository->getBySent('true', 5);

    $this->assertCount(5, $result);
    $this->assertTrue($result->first()->sent);
});


it('can create sent messages', function () {
    $values = [
        ['content' => 'Message 1', 'phone_number' => '1234567890'],
        ['content' => 'Message 2', 'phone_number' => '9876543210'],
    ];

    $this->mockRepository
        ->shouldReceive('createSentMessages')
        ->with($values)
        ->andReturn(true);

    $result = $this->mockRepository->createSentMessages($values);

    $this->assertTrue($result);
});


it('can get paginated recipients by sent status', function () {
    $recipients = Recipient::factory()->count(5)->make(['sent' => true]);

    $paginator = \Mockery::mock(LengthAwarePaginator::class);
    $paginator->shouldReceive('toArray')->andReturn([
        'data' => $recipients->toArray(),
        'meta' => [
            'current_page' => 1,
            'total' => 5,
            'last_page' => 1,
        ]
    ]);

    $this->mockRepository
        ->shouldReceive('getAsPaginatedBySent')
        ->with(true, 25)
        ->andReturn($paginator);

    $result = $this->mockRepository->getAsPaginatedBySent(true, 25);

    $this->assertCount(5, $result->toArray()['data']);
    $this->assertEquals(5, $result->toArray()['meta']['total']);
});
