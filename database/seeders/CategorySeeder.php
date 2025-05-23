<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Noticias',
            'slug' => 'noticias'
        ]);
        Category::create([
            'name' => 'Tareas',
            'slug' => 'tareas'
        ]);
        Category::create([
            'name' => 'Practicas',
            'slug' => 'practicas'
        ]);
        Category::create([
            'name' => ' CAD',
            'slug' => 'cad'
        ]);
    }
}
