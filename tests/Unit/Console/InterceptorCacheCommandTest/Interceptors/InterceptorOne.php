<?php

namespace Larapackages\Tests\Unit\Console\InterceptorCacheCommandTest\Interceptors;

use Larapackages\Interceptor\InterceptorInterface;

/**
 * Class InterceptorOne.
 */
class InterceptorOne implements InterceptorInterface
{
    public static function interceptors(): array
    {
        return [];
    }
}
