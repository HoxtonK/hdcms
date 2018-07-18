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
        #vue-form组件测试
        'http://hdcms.hd/vue-form-upload',
        'http://hdcms.hd/upload',
    ];
}
