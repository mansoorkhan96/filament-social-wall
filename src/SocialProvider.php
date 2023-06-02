<?php

namespace Mansoor\FilamentSocialWall;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
