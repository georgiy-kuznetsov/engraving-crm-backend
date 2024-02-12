<?php

namespace Database\Seeders\Initial;

use App\Models\Order\Source;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSourceSeeder extends Seeder
{
    public function run(): void
    {
        Source::factory()->state([
            'name' => 'Instagram',
            'description' => null,
            'index' => 1,
        ])->create();
        
        Source::factory()->state([
            'name' => 'Вконтакте',
            'description' => null,
            'index' => 2,
        ])->create();
        
        Source::factory()->state([
            'name' => 'Сайт',
            'description' => null,
            'index' => 3,
        ])->create();
        
        Source::factory()->state([
            'name' => 'Авито',
            'description' => null,
            'index' => 4,
        ])->create();
        
        Source::factory()->state([
            'name' => 'Друзья',
            'description' => null,
            'index' => 5,
        ])->create();
        
        Source::factory()->state([
            'name' => 'Звонки',
            'description' => null,
            'index' => 6,
        ])->create();
        
        Source::factory()->state([
            'name' => 'Партнеры',
            'description' => null,
            'index' => 7,
        ])->create();
    }
}
