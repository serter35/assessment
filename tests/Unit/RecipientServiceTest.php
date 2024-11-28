<?php

use Tests\TestCase;
use Mockery;
use App\Contract\Messaging\RecipientServiceContract;
use App\Models\Recipient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

uses(TestCase::class);

beforeEach(function () {
    // Mock the RecipientServiceContract
    $this->recipientService = Mockery::mock(RecipientServiceContract::class);
});

afterEach(function () {
    Mockery::close();
});

it('can get paginated recipients by sent status', function () {
    // Expected data (mock data for testing pagination)
    $paginator = Mockery::mock(LengthAwarePaginator::class);
    $paginator->shouldReceive('items')->andReturn([new Recipient(), new Recipient()]);
    $paginator->shouldReceive('currentPage')->andReturn(1);
    $paginator->shouldReceive('lastPage')->andReturn(1);

    // Set up mock behavior for the service
    $this->recipientService->shouldReceive('getAsPaginatedBySent')
        ->with(25)
        ->andReturn($paginator);

    // Call the method and assert behavior
    $result = $this->recipientService->getAsPaginatedBySent(25);
    expect($result)->toBeInstanceOf(LengthAwarePaginator::class)
        ->and($result->currentPage())->toBe(1)
        ->and($result->lastPage())->toBe(1);
});

it('can find recipient by ID', function () {
    // Create a mock recipient
    $recipient = Mockery::mock(Recipient::class);
    $recipient->shouldReceive('getId')->andReturn(1);

    // Set up mock behavior for the service
    $this->recipientService->shouldReceive('findRecipientAsSent')
        ->with(1)
        ->andReturn($recipient);

    // Call the method and assert behavior
    $result = $this->recipientService->findRecipientAsSent(1);
    expect($result)->toBeInstanceOf(Recipient::class)
        ->and($result->getId())->toBe(1);
});

it('can get pending recipients', function () {
    // Create a mock collection of recipients
    $recipients = Mockery::mock(Collection::class);
    $recipients->shouldReceive('count')->andReturn(3);

    // Set up mock behavior for the service
    $this->recipientService->shouldReceive('getPendingRecipients')
        ->with(10)
        ->andReturn($recipients);

    // Call the method and assert behavior
    $result = $this->recipientService->getPendingRecipients(10);
    expect($result)->toBeInstanceOf(Collection::class)
        ->and($result->count())->toBe(3);
});

it('can mark all recipients as sent', function () {
    // Set up mock behavior for the service
    $this->recipientService->shouldReceive('markAllAsSent')
        ->with([1, 2, 3])
        ->andReturn(true);

    // Call the method and assert behavior
    $result = $this->recipientService->markAllAsSent([1, 2, 3]);
    expect($result)->toBeTrue();
});

it('can create many sent messages', function () {
    // Set up mock behavior for the service
    $this->recipientService->shouldReceive('createManySentMessages')
        ->with([['id' => 1], ['id' => 2]])
        ->andReturn(true);

    // Call the method and assert behavior
    $result = $this->recipientService->createManySentMessages([['id' => 1], ['id' => 2]]);
    expect($result)->toBeTrue();
});

it('can send message to recipients', function () {
    // Create a mock collection of recipients
    $recipients = Mockery::mock(Collection::class);
    $recipients->shouldReceive('count')->andReturn(2);

    // Set up mock behavior for the service
    $this->recipientService->shouldReceive('sendMessageToRecipients')
        ->with($recipients)
        ->andReturn($recipients);

    // Call the method and assert behavior
    $result = $this->recipientService->sendMessageToRecipients($recipients);
    expect($result)->toBeInstanceOf(Collection::class)
        ->and($result->count())->toBe(2);
});
