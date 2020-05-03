<?php

namespace Larapackages\Tests\Unit\Console\InterceptorCacheCommandTest\Interceptors;

use Larapackages\Interceptor\InterceptorInterface;

/**
 * Class InterceptorTwo.
 */
class InterceptorTwo implements InterceptorInterface
{
    public static function interceptors(): array
    {
        return [];
    }
}
