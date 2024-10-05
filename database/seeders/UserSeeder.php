<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'ebrahem',
            'email' => 'ebrahem@gmail.com',
            'password' => '$2y$12$Z6IgiLqit2lVpJWefeXmwOupc/dT09qkVkNx98vuTMdEkIZrh76Nq',
            'is_online' => false
        ]);

        User::create([
            'name' => 'ahmed',
            'email' => 'ahmed@gmail.com',
            'password' => '$2y$12$Z6IgiLqit2lVpJWefeXmwOupc/dT09qkVkNx98vuTMdEkIZrh76Nq',
            'is_online' => false
        ]);

        User::create([
            'name' => 'rashed',
            'email' => 'rashed@gmail.com',
            'password' => '$2y$12$Z6IgiLqit2lVpJWefeXmwOupc/dT09qkVkNx98vuTMdEkIZrh76Nq',
            'is_online' => false
        ]);
    }
}
