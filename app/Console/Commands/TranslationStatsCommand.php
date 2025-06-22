<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Translation;
use App\Models\Locale;
use App\Models\Tag;
use App\Models\TranslationKey;
use Illuminate\Support\Facades\DB;

class TranslationStatsCommand extends Command
{
    protected $signature = 'translations:stats';

    protected $description = 'Display translation statistics';

    public function handle(): int
    {
        $this->info('Translation Statistics');
        $this->line('========================');

        // Basic counts
        $translationKeysCount = TranslationKey::count();
        $translationsCount = Translation::count();
        $localesCount = Locale::count();
        $tagsCount = Tag::count();

        $this->table(['Metric', 'Count'], [
            ['Translation Keys', number_format($translationKeysCount)],
            ['Translations', number_format($translationsCount)],
            ['Locales', $localesCount],
            ['Tags', $tagsCount],
        ]);

        // Translations per locale
        $this->newLine();
        $this->info('Translations per Locale:');
        $localeStats = DB::table('translations')
            ->join('locales', 'translations.locale_id', '=', 'locales.id')
            ->select('locales.code', 'locales.name', DB::raw('count(*) as count'))
            ->groupBy('locales.id', 'locales.code', 'locales.name')
            ->orderBy('count', 'desc')
            ->get();

        $localeTable = $localeStats->map(function ($stat) {
            return [$stat->code, $stat->name, number_format($stat->count)];
        })->toArray();

        $this->table(['Code', 'Name', 'Translations'], $localeTable);

        // Most used tags
        $this->newLine();
        $this->info('Most Used Tags:');
        $tagStats = DB::table('translation_tags')
            ->join('tags', 'translation_tags.tag_id', '=', 'tags.id')
            ->select('tags.name', DB::raw('count(*) as count'))
            ->groupBy('tags.id', 'tags.name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        $tagTable = $tagStats->map(function ($stat) {
            return [$stat->name, number_format($stat->count)];
        })->toArray();

        $this->table(['Tag', 'Usage Count'], $tagTable);

        return self::SUCCESS;
    }
}
