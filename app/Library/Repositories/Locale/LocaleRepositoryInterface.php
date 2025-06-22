<?php namespace TMS\Repositories\Locale;

use App\Models\Locale;
use TMS\Abstracts\RepositoryInterface;

interface LocaleRepositoryInterface extends RepositoryInterface
{
    public function fetch_all();
    public function find(Locale $locale);
    public function create(array $data);
    public function update(Locale $locale, array $data);
    public function deleteLocale(Locale $locale);
}
