<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;
    private Client $client;

    private function login(): void
    {
        $this->user = User::factory()->createOne();
        $this->be($this->user);
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->login();

        $this->client = Client::factory()->createOne();
    }

    protected function withUrl(?string $url = null): string
    {
        return '/client/' . $this->client->id . $url;
    }

    public function testList(): void
    {
        $response = $this->get($this->withUrl('/transaction'));
        $response->assertStatus(200);
        $response->assertSeeText('Transactions');
    }

    public function testCreate(): void
    {
        $response = $this->get($this->withUrl('/transaction/create'));
        $response->assertStatus(200);
        $response->assertSeeText('Create');
    }

    public function testStore(): void
    {
        $params = [
            ['amount' => '45,22', 'transaction_date' => now()->format('Y-m-d'), 'error' => true],
            ['amount' => '25.34', 'transaction_date' => now()->format('d.m.Y'), 'error' => true],
            ['amount' => '187.35', 'transaction_date' => now()->format('Y-m-d'), 'error' => false],
        ];

        foreach ($params as $param) {
            $response = $this->post($this->withUrl('/transaction'), $param);
            $response->assertStatus(302);
            $param['error'] ?: $response->assertSessionHasNoErrors();
        }
    }

    public function testEdit(): void
    {
        $transaction = Transaction::factory()->createOne([
            'client_id' => $this->client->id
        ]);

        $response = $this->get($this->withUrl("/transaction/{$transaction->id}/edit"));
        $response->assertStatus(200);
        $response->assertSeeText('Update');
    }

    public function testUpdate(): void
    {
        $transaction = Transaction::factory()->createOne([
            'client_id' => $this->client->id
        ]);

        $newParams = [
            'amount' => 999.99
        ];

        $response = $this->put($this->withUrl('/transaction/' . $transaction->id), [
            'amount' => $newParams['amount'],
            'transaction_date' => $transaction->transaction_date->format('Y-m-d'),
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertEquals($newParams['amount'], Transaction::find($transaction->id)->amount);
    }
}
