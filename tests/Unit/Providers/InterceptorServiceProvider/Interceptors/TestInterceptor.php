<?php

namespace Larapackages\Tests\Unit\Providers\InterceptorServiceProvider\Interceptors;

use Larapackages\Interceptor\InterceptorInterface;

/**
 * Class TestInterceptor
 *
 * @package Larapackages\Tests\Unit\Providers\InterceptorServiceProvider\Interceptors
 */
class TestInterceptor implements InterceptorInterface
{
    public static function interceptors(): array
    {
        return [];
    }
}