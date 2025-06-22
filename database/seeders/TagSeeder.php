<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'mobile', 'description' => 'Mobile application translations'],
            ['name' => 'desktop', 'description' => 'Desktop application translations'],
            ['name' => 'web', 'description' => 'Web application translations'],
            ['name' => 'api', 'description' => 'API related translations'],
            ['name' => 'admin', 'description' => 'Admin panel translations'],
            ['name' => 'user', 'description' => 'User interface translations'],
            ['name' => 'error', 'description' => 'Error message translations'],
            ['name' => 'validation', 'description' => 'Validation message translations'],
            ['name' => 'email', 'description' => 'Email template translations'],
            ['name' => 'notification', 'description' => 'Notification translations'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag['name']], $tag);
        }
    }
}
