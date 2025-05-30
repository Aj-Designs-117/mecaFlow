<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'site_title',
            'value' => 'MecaLink',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Setting::create([
            'key' => 'site_description',
            'value' => 'Bitácora digital de un futuro ingeniero mecatrónico. Aquí encontrarás proyectos, prácticas, códigos, diseños CAD, apuntes académicos y noticias relevantes sobre tecnología, automatización y robótica.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Setting::create([
            'key' => 'site_author',
            'value' => 'Aj Designs',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Setting::create([
            'key' => 'site_number',
            'value' => '+53 --- --- ----',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Setting::create([
            'key' => 'site_email',
            'value' => '231244@up.chiapas.edu.mx',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Setting::create([
            'key' => 'facebook_url',
            'value' => 'https://www.facebook.com/mecaupch',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Setting::create([
            'key' => 'instagram_url',
            'value' => 'https://www.instagram.com/mecatronicaup/',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Setting::create([
            'key' => 'web_url',
            'value' => 'https://www.upchiapas.edu.mx/',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
