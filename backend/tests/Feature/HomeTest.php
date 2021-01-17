<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use DatabaseTransactions;

    public function testGuest(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302);
    }

    public function testUser(): void
    {
        $this->be(User::factory()->createOne());
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Dashboard');
    }
}
