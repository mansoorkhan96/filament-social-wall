<?php

namespace Mansoor\FilamentSocialWall\Models\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface SocialWall
{
    public function scopeCurrent(Builder $query);
}
