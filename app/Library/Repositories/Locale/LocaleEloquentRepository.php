<?php namespace TMS\Repositories\Locale;

use App\Models\Locale;
use TMS\Abstracts\EloquentRepository;
use TMS\Repositories\Locale\LocaleRepositoryInterface;

class LocaleEloquentRepository extends EloquentRepository implements LocaleRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Locale();
    }

    public function fetch_all()
    {
        return $this->model->all();
    }

    public function find(Locale $locale)
    {
        return $locale;
    }

    public function create($data)
    {
        $locale = new $this->model();
        $locale->name = $data['name'];
        $locale->code = $data['code'];
        $locale->save();
        return $locale;
    }

    public function update(Locale $locale, $data)
    {
        if ($locale) {
            $locale->name = $data['name'] ?? $locale->name;
            $locale->code = $data['code'] ?? $locale->code;
            $locale->save();
        }
        return $locale;
    }

    public function deleteLocale(Locale $locale)
    {
        if ($locale) {
            $locale->delete();
        }
    }
}
