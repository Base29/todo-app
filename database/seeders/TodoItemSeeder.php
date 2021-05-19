<?php

namespace Database\Seeders;

use App\Models\TodoItem;
use Illuminate\Database\Seeder;

class TodoItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TodoItem::factory()->times(40)->create();
    }
}