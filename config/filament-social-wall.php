<?php

return [
    /**
     * This is where you specify if the social provider belongs to another model e.g. App\Models\User
     * When specified, social providers will be unique to that Model.
     *
     * Example: social_provider_relation' => App\Models\User::class,
     */
    'social_provider_relation' => null,

    'redirect_after_callback' => '/admin',
];
