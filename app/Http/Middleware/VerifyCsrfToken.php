<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //'http://localhost:8000/broadcasting/auth'
        'stripe/*',
        'http://localhost:8000/broadcasting/auth',
        'http://localhost:8000/*',
        'http://localhost:8000/broadcasting/*',
        'https://sockjs-ap3.pusher.com/*'
        'sockjs-ap3.pusher.com/'
    ];
}
