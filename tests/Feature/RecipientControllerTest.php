<?php

use App\Models\Recipient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $this->artisan('migrate:fresh');
});

/**
 * Index methodu test ediliyor
 * @uses \App\Http\Controllers\RecipientController::index()
 */
it('can get all sent message recipients with pagination', function () {
    Recipient::factory()->count(5)->create([
        'sent' => true
    ]);

    $response = $this->getJson('/api/recipients?page=1');

    $response->assertStatus(200);

    $data = $response->json();

    $this->assertArrayHasKey('data', $data);
    $this->assertArrayHasKey('meta', $data);
    $this->assertArrayHasKey('links', $data);

    $this->assertNotEmpty($data['data']);

    $this->assertArrayHasKey('current_page', $data['meta']);
    $this->assertArrayHasKey('last_page', $data['meta']);
    $this->assertArrayHasKey('total', $data['meta']);

    $this->assertEquals(1, $data['meta']['current_page']);
    $this->assertEquals(5, $data['meta']['total']);
    $this->assertEquals(1, $data['meta']['last_page']);

    $this->assertArrayHasKey('first', $data['links']);
    $this->assertArrayHasKey('last', $data['links']);
    $this->assertArrayHasKey('prev', $data['links']);
    $this->assertArrayHasKey('next', $data['links']);
});

/**
 * Show methodu test ediliyor
 * @uses \App\Http\Controllers\RecipientController::show()
 */
it('can get a single sent message recipient by ID', function () {
    $recipient = Recipient::factory()->create([
        'sent' => true,
    ]);

    $response = $this->getJson("/api/recipients/{$recipient->id}");

    $response->assertStatus(200);

    $response->assertJsonFragment([
        'id' => $recipient->id,
        'content' => $recipient->content->value,
        'phone_number' => $recipient->phone_number->value,
        'sent' => $recipient->sent,
    ]);
});

/**
 * Show methodu 404 senaryosu test ediliyor
 * @uses \App\Http\Controllers\RecipientController::show()
 */
it('returns 404 when recipient is not found', function () {
    $response = $this->getJson('/api/recipients/9999');

    $response->assertStatus(404);
});
