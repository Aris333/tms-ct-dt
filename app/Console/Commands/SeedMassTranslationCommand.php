<?php

namespace App\Console\Commands;

use Database\Seeders\MassTranslationSeeder;
use Illuminate\Console\Command;

class SeedMassTranslationCommand extends Command
{
    protected $signature = 'translations:seed-mass {--records=100000 : Number of translation keys to create}';

    protected $description = 'Seed a large number of translations for performance testing';

    public function handle(): int
    {
        $records = $this->option('records');

        $this->info("Starting to seed {$records} translation records...");

        $seeder = new MassTranslationSeeder();
        $seeder->run();

        $this->info('Mass translation seeding completed successfully!');

        return self::SUCCESS;
    }
}
