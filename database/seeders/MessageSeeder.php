<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::create([
            'sender_id' => 1,
            'recipient_id' => 2,
            'content' => 'hello',
            'is_seen' => false,
        ]);

        Message::create([
            'sender_id' => 1,
            'recipient_id' => 2,
            'content' => 'hello',
            'is_seen' => false,
        ]);

        Message::create([
            'sender_id' => 1,
            'recipient_id' => 3,
            'content' => 'hello',
            'is_seen' => false,
        ]);

        Message::create([
            'sender_id' => 2,
            'recipient_id' => 1,
            'content' => 'hello',
            'is_seen' => false,
        ]);

        Message::create([
            'sender_id' => 1,
            'recipient_id' => 3,
            'content' => 'hello',
            'is_seen' => false,
        ]);

    }
}
