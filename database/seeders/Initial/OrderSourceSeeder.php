<?php

namespace Database\Seeders\Initial;

use App\Models\OrderSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSourceSeeder extends Seeder
{
    public function run(): void
    {
        OrderSource::factory()->state([
            'name' => 'Instagram',
            'description' => null,
            'index' => 1,
        ])->create();
        
        OrderSource::factory()->state([
            'name' => 'Вконтакте',
            'description' => null,
            'index' => 2,
        ])->create();
        
        OrderSource::factory()->state([
            'name' => 'Сайт',
            'description' => null,
            'index' => 3,
        ])->create();
        
        OrderSource::factory()->state([
            'name' => 'Авито',
            'description' => null,
            'index' => 4,
        ])->create();
        
        OrderSource::factory()->state([
            'name' => 'Друзья',
            'description' => null,
            'index' => 5,
        ])->create();
        
        OrderSource::factory()->state([
            'name' => 'Звонки',
            'description' => null,
            'index' => 6,
        ])->create();
        
        OrderSource::factory()->state([
            'name' => 'Партнеры',
            'description' => null,
            'index' => 7,
        ])->create();
    }
}
