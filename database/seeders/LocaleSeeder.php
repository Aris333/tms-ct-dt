<?php

namespace Database\Seeders;

use App\Models\Locale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $locales = [
            ['code' => 'en', 'name' => 'English', 'is_active' => true],
            ['code' => 'fr', 'name' => 'French', 'is_active' => true],
            ['code' => 'es', 'name' => 'Spanish', 'is_active' => true],
            ['code' => 'de', 'name' => 'German', 'is_active' => true],
            ['code' => 'it', 'name' => 'Italian', 'is_active' => true],
            ['code' => 'pt', 'name' => 'Portuguese', 'is_active' => true],
            ['code' => 'zh', 'name' => 'Chinese', 'is_active' => true],
            ['code' => 'ja', 'name' => 'Japanese', 'is_active' => true],
            ['code' => 'ko', 'name' => 'Korean', 'is_active' => true],
            ['code' => 'ar', 'name' => 'Arabic', 'is_active' => true],
        ];

        foreach ($locales as $locale) {
            Locale::firstOrCreate(['code' => $locale['code']], $locale);
        }
    }
}
