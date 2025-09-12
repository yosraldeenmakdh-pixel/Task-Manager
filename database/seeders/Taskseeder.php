<?php

namespace Database\Seeders;


use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class Taskseeder extends Seeder
{
    public function run(): void
    {
        Task::factory()->count(25)->create() ;
    }
}
