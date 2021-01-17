<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->createOne([
            'email' => 'admin@admin.com',
            'name' => 'Admin'
        ]);

        Client::factory(15)->create()->each(fn(Client $client) =>
            Transaction::factory(mt_rand(1, 4))->create([
                'client_id' => $client->id
            ])
        );
    }
}
