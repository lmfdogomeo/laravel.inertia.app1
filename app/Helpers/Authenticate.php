<?php

if (! function_exists('authUser')) {
    /**
     * Get the currently authenticated user.
     *
     * @return \App\Models\User|\App\Models\CompanyUser|null The authenticated user, or null if no user is authenticated.
     */
    function authUser(): \App\Models\User
    {
        return auth()->user();
    }
}

if (! function_exists('authenticatedUser')) {
    /**
     * Get the currently authenticated user.
     *
     * @return \App\Models\User|\App\Models\CompanyUser|null The authenticated user, or null if no user is authenticated.
     */
    function authenticatedUser(): \App\Models\User
    {
        return auth()->user();
    }
}

if (! function_exists('isAuthenticated')) {
    /**
     * Determine if the currently authenticated user is a company user.
     *
     * @return bool True if the user is a company user, false otherwise.
     */
    function isAuthenticated(): bool
    {
        return auth()->check();
    }
}

if (! function_exists('isAdminUser')) {
    /**
     * Determine if the currently authenticated user is a company user.
     *
     * @return bool True if the user is a company user, false otherwise.
     */
    function isAdminUser(): bool
    {
        return authUser()?->isAdminUser() ?? false;
    }
}

if (! function_exists('isMerchantUser')) {
    /**
     * Determine if the currently authenticated user is a company user.
     *
     * @return bool True if the user is a company user, false otherwise.
     */
    function isMerchantUser(): bool
    {
        return authUser()?->isMerchantUser() ?? false;
    }
}
