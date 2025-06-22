<?php

namespace TMS\Repositories\Translation;

use App\Models\Locale;
use App\Models\Tag;
use App\Models\Translation;
use App\Models\TranslationKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TMS\Abstracts\EloquentRepository;
use TMS\Repositories\Translation\TranslationRepositoryInterface;

class TranslationEloquentRepository extends EloquentRepository  implements TranslationRepositoryInterface
{
    public function __construct(
        private TranslationRepositoryInterface $translationRepository,
    ) {}
    public function getTranslations(Locale $locale, Request $request)
    {
        $filters = $request->filters;
        $pageNum = $request->pageNum;
        $perPage = $request->perPage;

        $query = $locale->translations()
            ->with(['translationKey', 'locale', 'tags'])
            ->when(isset($filters['locale']), function ($q) use ($filters) {
                $q->byLocale($filters['locale']);
            })
            ->when(isset($filters['key']), function ($q) use ($filters) {
                $q->byKey($filters['key']);
            })
            ->when(isset($filters['tags']) && is_array($filters['tags']), function ($q) use ($filters) {
                $q->byTags($filters['tags']);
            })
            ->when(isset($filters['updated_since']), function ($q) use ($filters) {
                $q->where('updated_at', '>=', $filters['updated_since']);
            })
            ->orderBy('updated_at', 'desc');

        return $query->paginate($perPage, ['*'], 'page', $pageNum);
    }

    public function find(Locale $locale, Translation $translation): Translation
    {
        return $translation->load(['translationKey', 'locale', 'tags']);
    }

    public function create(Locale $locale, $data)
    {
        return DB::transaction(function () use ($locale, $data) {
            $translationKey = TranslationKey::firstOrCreate(
                ['key' => $data['key']],
                ['description' => $data['key_description'] ?? null]
            );

            return $locale->translations()->create([
                'translation_key_id' => $translationKey->id,
                'locale_id' => $locale->id,
                'value' => $data['value'],
            ]);
            if (isset($data['tags'])) {
                $this->attachTags($translation, $data['tags']);
            }
        });
    }

    public function update(Locale $locale, Translation $translation, $data)
    {
        return DB::transaction(function () use ($translation, $data) {

            $updateData = [];

            if (isset($data['value'])) {
                $updateData['value'] = $data['value'];
            }

            if (isset($data['key'])) {
                $translationKey = TranslationKey::firstOrCreate(
                    ['key' => $data['key']],
                    ['description' => $data['key_description'] ?? null]
                );
                $updateData['translation_key_id'] = $translationKey->id;
            }

            if (isset($data['locale_code'])) {
                $locale = Locale::where('code', $data['locale_code'])->firstOrFail();
                $updateData['locale_id'] = $locale->id;
            }

            $translation->update($updateData);

            return $translation->fresh(['translationKey', 'locale', 'tags']);
        });
    }

    public function deleteTranslation(Locale $locale, Translation $translation)
    {
        if ($locale && $translation) {
            $translation->delete();
        }
    }

    private function attachTags(Translation $translation, array $tagNames): void
    {
        $tags = collect($tagNames)->map(function ($tagName) {
            return Tag::firstOrCreate(['name' => $tagName]);
        });

        $translation->tags()->attach($tags->pluck('id'));
    }

    private function syncTags(Translation $translation, array $tagNames): void
    {
        $tags = collect($tagNames)->map(function ($tagName) {
            return Tag::firstOrCreate(['name' => $tagName]);
        });

        $translation->tags()->sync($tags->pluck('id'));
    }

    public function getTranslationsForExport(string $locale, array $tags = []): array
    {
        $query = DB::table('translations as t')
            ->join('translation_keys as tk', 't.translation_key_id', '=', 'tk.id')
            ->join('locales as l', 't.locale_id', '=', 'l.id')
            ->where('l.code', $locale)
            ->select('tk.key', 't.value', 't.updated_at');

        if (!empty($tags)) {
            $query->join('translation_tags as tt', 't.id', '=', 'tt.translation_id')
                ->join('tags as tag', 'tt.tag_id', '=', 'tag.id')
                ->whereIn('tag.name', $tags)
                ->groupBy('t.id', 'tk.key', 't.value', 't.updated_at');
        }

        $results = $query->orderBy('tk.key')->get();

        // Convert to nested array structure
        $translations = [];
        $lastUpdated = null;

        foreach ($results as $result) {
            $keys = explode('.', $result->key);
            $current = &$translations;

            foreach ($keys as $key) {
                if (!isset($current[$key])) {
                    $current[$key] = [];
                }
                $current = &$current[$key];
            }

            $current = $result->value;

            if (!$lastUpdated || $result->updated_at > $lastUpdated) {
                $lastUpdated = $result->updated_at;
            }
        }

        return [
            'translations' => $translations,
            'last_updated' => $lastUpdated,
            'locale' => $locale,
            'tags' => $tags,
        ];
    }
}
