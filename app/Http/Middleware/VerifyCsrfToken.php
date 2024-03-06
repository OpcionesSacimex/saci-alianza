<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'webhook',
        'https://52fa-187-217-222-19.ngrok-free.app/webhook',
        'opsaciRiskCoverage'
        //
    ];
}
