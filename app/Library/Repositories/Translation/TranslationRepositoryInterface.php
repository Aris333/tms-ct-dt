<?php

namespace TMS\Repositories\Translation;

use App\Models\Locale;
use App\Models\Translation;
use Illuminate\Http\Request;
use TMS\Abstracts\RepositoryInterface;

interface TranslationRepositoryInterface extends RepositoryInterface
{
    public function getTranslations(Locale $locale, Request $request);
    public function find(Locale $locale, Translation $translation);
    public function create(Locale $locale, array $data);
    public function update(Locale $locale, Translation $translation, array $data);
    public function deleteTranslation(Locale $locale, Translation $translation );
    public function getTranslationsForExport(string $locale, array $tags = []);
}
