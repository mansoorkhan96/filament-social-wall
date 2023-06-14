<?php

namespace Mansoor\FilamentSocialWall\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;

class SocialProvider extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'provider_name' => SocialProviderName::class,
    ];

    public function parent(): BelongsTo
    {
        /**
         * @var \Illuminate\Database\Eloquent\Model
         */
        $parentModel = new (config('filament-social-wall.parent_model'));

        return $this->belongsTo(
            config('filament-social-wall.parent_model'),
            $parentModel->getForeignKey()
        );
    }

    public function scopeWhereBelongsToParent(Builder $query): Builder
    {
        if (blank(config('filament-social-wall.parent_model'))) {
            return $query;
        }

        $parentModel = new (config('filament-social-wall.parent_model'));

        return $query->when(
            filled(config('filament-social-wall.parent_model')),
            fn (Builder $query) => $query->whereBelongsTo($parentModel->current(), 'parent')
        );
    }
}
