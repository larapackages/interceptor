<?php

namespace Larapackages\Tests\Unit\Services\InterceptorService\Interceptors;

use Larapackages\Interceptor\InterceptorInterface;

/**
 * Class TestInterceptor.
 */
class TestInterceptor implements InterceptorInterface
{
    public static function interceptors(): array
    {
        return [];
    }
}
