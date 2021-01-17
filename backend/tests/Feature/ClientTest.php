<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;

    private function login(): void
    {
        $this->user = User::factory()->createOne();
        $this->be($this->user);
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->login();
    }

    public function testList(): void
    {
        $response = $this->get('/client');
        $response->assertStatus(200);
        $response->assertSeeText('Clients');
    }

    public function testListFilter(): void
    {
        $queries = [
            ['id' => 'test', 'name' => '123', 'email' => '456', 'status' => 200],
            ['id' => '.~\\', 'email' => '*', 'name' => 0, 'status' => 200],
            ['id' => ['Hello'], 'email' => 0, 'status' => 302],
        ];

        foreach ($queries as $params) {
            $queryString = http_build_query($params);
            $response = $this->get('/client?' . $queryString);
            $response->assertStatus($params['status']);
        }
    }

    public function testCreate(): void
    {
        $response = $this->get('/client/create');
        $response->assertStatus(200);
        $response->assertSeeText('Create');
    }

    public function testStore(): void
    {
        Storage::fake('images');

        $queries = [
            Client::factory()->makeOne()->getAttributes(),
            Client::factory()->makeOne()->getAttributes()
        ];

        foreach ($queries as $query) {
            $fakeImage = $query['avatar'];

            $response = $this->post('/client', array_merge($query, [
                'avatar' => UploadedFile::fake()->image($query['avatar'], 150, 150)
            ]));

            Storage::delete($fakeImage);

            $response->assertSessionHasNoErrors();
            $response->assertStatus(302);
        }
    }

    public function testEdit(): void
    {
        $client = Client::factory()->createOne();

        $response = $this->get("/client/{$client->id}/edit");
        $response->assertStatus(200);
        $response->assertSeeText('Update');

        Storage::delete($client->avatar);
    }

    public function testUpdate(): void
    {
        $client = Client::factory()->createOne();

        $newParams = [
            'email' => 'test@' . (Uuid::uuid4()) . '.com',
        ];

        $response = $this->put('/client/' . $client->id, [
            'first_name' => $client->first_name,
            'last_name' => $client->last_name,
            'email' => $newParams['email']
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertEquals($newParams['email'], Client::find($client->id)->email);
    }
}
