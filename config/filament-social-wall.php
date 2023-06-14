<?php

return [
    /**
     * This is where you specify if the social provider belongs to another model e.g. App\Models\User
     * When specified, social providers will be unique to that Model.
     *
     * Example: parent_model' => App\Models\User::class,
     */
    'parent_model' => null,

    'redirect_after_callback' => '/admin',
];
