<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\News;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
    
        User::firstOrCreate(
        ['email' => 'test@example.com'],
        [
            'name' => 'Test User',
            'password' => bcrypt('password'), // обязательно, иначе ошибка
        ]
    );
    $this->call([
        NewsSeeder::class,
    ]);
    }
}
