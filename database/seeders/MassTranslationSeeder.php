<?php

namespace Database\Seeders;

use App\Models\Locale;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MassTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting mass translation seeding...');

        // Ensure locales and tags exist
        $this->call(LocaleSeeder::class);
        $this->call(TagSeeder::class);

        $locales = Locale::all();
        $tags = Tag::all();
        $batchSize = 1000;
        $totalRecords = 100000;

        // Common translation key patterns
        $keyPatterns = [
            'auth.login.title',
            'auth.login.email',
            'auth.login.password',
            'auth.login.submit',
            'auth.register.title',
            'user.profile.name',
            'user.profile.email',
            'user.settings.title',
            'dashboard.welcome',
            'dashboard.stats',
            'product.name',
            'product.description',
            'product.price',
            'cart.add',
            'cart.remove',
            'cart.checkout',
            'order.status',
            'order.total',
            'payment.success',
            'payment.failed',
            'error.404',
            'error.500',
            'validation.required',
            'validation.email',
            'notification.success',
            'notification.error',
        ];

        $valueTemplates = [
            'auth.login.title' => ['Login', 'Se connecter', 'Iniciar sesión'],
            'auth.login.email' => ['Email', 'E-mail', 'Correo electrónico'],
            'auth.login.password' => ['Password', 'Mot de passe', 'Contraseña'],
            'auth.login.submit' => ['Sign In', 'Se connecter', 'Iniciar sesión'],
            'user.profile.name' => ['Name', 'Nom', 'Nombre'],
            'dashboard.welcome' => ['Welcome', 'Bienvenue', 'Bienvenido'],
            'error.404' => ['Page not found', 'Page non trouvée', 'Página no encontrada'],
            'validation.required' => ['This field is required', 'Ce champ est requis', 'Este campo es obligatorio'],
        ];

        DB::transaction(function () use ($locales, $tags, $keyPatterns, $valueTemplates, $batchSize, $totalRecords) {
            $recordsCreated = 0;
            $translationKeysBatch = [];
            $translationsBatch = [];
            $translationTagsBatch = [];

            while ($recordsCreated < $totalRecords) {
                for ($i = 0; $i < $batchSize && $recordsCreated < $totalRecords; $i++) {
                    $baseKey = $keyPatterns[array_rand($keyPatterns)];
                    $uniqueKey = $baseKey . '.' . uniqid() . '.' . $recordsCreated;

                    // Create translation key
                    $translationKeyId = $recordsCreated + 1;
                    $translationKeysBatch[] = [
                        'id' => $translationKeyId,
                        'key' => $uniqueKey,
                        'description' => 'Auto-generated translation key',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Create translations for each locale
                    foreach ($locales as $localeIndex => $locale) {
                        $translationId = ($recordsCreated * $locales->count()) + $localeIndex + 1;

                        // Generate value based on template or fallback
                        $value = $this->generateTranslationValue($baseKey, $locale->code, $valueTemplates);

                        $translationsBatch[] = [
                            'id' => $translationId,
                            'translation_key_id' => $translationKeyId,
                            'locale_id' => $locale->id,
                            'value' => $value,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        // Randomly assign tags
                        if (rand(1, 100) <= 70) { // 70% chance of having tags
                            $randomTags = $tags->random(rand(1, 3));
                            foreach ($randomTags as $tag) {
                                $translationTagsBatch[] = [
                                    'translation_id' => $translationId,
                                    'tag_id' => $tag->id,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ];
                            }
                        }
                    }

                    $recordsCreated++;
                }

                // Insert batches
                if (!empty($translationKeysBatch)) {
                    DB::table('translation_keys')->insert($translationKeysBatch);
                    $translationKeysBatch = [];
                }

                if (!empty($translationsBatch)) {
                    DB::table('translations')->insert($translationsBatch);
                    $translationsBatch = [];
                }

                if (!empty($translationTagsBatch)) {
                    DB::table('translation_tags')->insert($translationTagsBatch);
                    $translationTagsBatch = [];
                }

                $this->command->info("Created $recordsCreated translation keys...");
            }
        });

        $this->command->info("Mass translation seeding completed! Created $totalRecords translation keys with multiple locales.");
    }

    private function generateTranslationValue(string $baseKey, string $localeCode, array $templates): string
    {
        if (isset($templates[$baseKey])) {
            $values = $templates[$baseKey];
            switch ($localeCode) {
                case 'fr':
                    return $values[1] ?? $values[0] . ' (FR)';
                case 'es':
                    return $values[2] ?? $values[0] . ' (ES)';
                default:
                    return $values[0] ?? 'Default Value';
            }
        }

        return "Sample translation for {$baseKey} in {$localeCode}";
    }
}
