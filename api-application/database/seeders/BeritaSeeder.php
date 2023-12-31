<?php

namespace Database\Seeders;

use App\Models\BeritaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BeritaModel::factory(30)->create();
    }
}
