<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Translation extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    /** @use SoftDeletes<\Database\Eloquent\SoftDeletes> */
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'translation_key_id',
        'locale_id',
        'value',
    ];

    public function translationKey(): BelongsTo
    {
        return $this->belongsTo(TranslationKey::class);
    }

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'translation_tags');
    }

    public function scopeByLocale(Builder $query, string $localeCode): Builder
    {
        return $query->whereHas('locale', function ($q) use ($localeCode) {
            $q->where('code', $localeCode);
        });
    }

    public function scopeByKey(Builder $query, string $key): Builder
    {
        return $query->whereHas('translationKey', function ($q) use ($key) {
            $q->where('key', $key);
        });
    }

    public function scopeByTags(Builder $query, array $tags): Builder
    {
        return $query->whereHas('tags', function ($q) use ($tags) {
            $q->whereIn('name', $tags);
        });
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('value', 'LIKE', "%{$search}%")
                ->orWhereHas('translationKey', function ($subQ) use ($search) {
                    $subQ->where('key', 'LIKE', "%{$search}%");
                });
        });
    }
}
