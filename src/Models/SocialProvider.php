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

    public function owner(): BelongsTo
    {
        /**
         * @var \Illuminate\Database\Eloquent\Model
         */
        $relatedModel = new (config('filament-social-wall.social_provider_relation'));

        return $this->belongsTo(
            config('filament-social-wall.social_provider_relation'),
            $relatedModel->getForeignKey()
        );
    }

    public function scopeWhereBelongsToOwner(Builder $query): Builder
    {
        // TODO: ::current()
        return $query->when(
            filled(config('filament-social-wall.social_provider_relation')),
            fn (Builder $query) => $query->whereBelongsTo(\App\Models\Website::current(), 'owner')
        );
    }
}
