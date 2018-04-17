<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'createlinks/utility/*',
        'settings/create_config/*',
        'vote/',
        'preview/',
        'comments/show',
        'notification/*',
        'linktype/*',
        'myvotes/project',
    ];
}
