<?php

namespace Larapackages\Interceptor;

interface InterceptorInterface
{
    /**
     * @return array
     */
    public static function interceptors(): array;
}
