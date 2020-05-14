[![Build Status](https://circleci.com/gh/larapackages/interceptor.svg?style=shield)](https://circleci.com/gh/larapackages/interceptor)
[![StyleCI Status](https://github.styleci.io/repos/260661140/shield)](https://github.styleci.io/repos/260661140)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/8cb5b3db6b0d4255a8723c961be36291)](https://www.codacy.com/gh/larapackages/interceptor?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=larapackages/interceptor&amp;utm_campaign=Badge_Grade)
![StyleCI Status](https://img.shields.io/packagist/dt/larapackages/interceptor)

# Why do I need it
For intercept calls to classes and abstract part of the logic to smaller classes

# Installation
Install with composer
~~~
composer require larapackages/interceptor
~~~

## Publish
~~~
php artisan vendor:publish --provider="Larapackages\Interceptor\Providers\InterceptorServiceProvider"
~~~

# Usages

In your `SomeClass` implements `Larapackages\Interceptor\InterceptorInterface`.
```php
class SomeClass implements \Larapackages\Interceptor\InterceptorInterface {
    public static function interceptors(): array
    {
        return [
            // Classes namespaces that will intercept this class
        ];
    }
};
```

The you must use Laravel container to make the class for interceptor works.

[Laravel container resolving documentation](https://laravel.com/docs/7.x/container#resolving)

```php
$class = app()->make(SomeClass::class);
$class = resolve(SomeClass::class);
```

## Modifying arguments

```php
class ArgInterceptor {
    public function getName($name) {
        $name = mb_strtoupper($name);
        
        return compact('name');
    }
};

class ArgClass implements \Larapackages\Interceptor\InterceptorInterface {
    public function getName($name) {
        return $name;
    }

    public static function interceptors(): array
    {
        return [
            ArgInterceptor::class
        ];
    }
};

$class = app()->make(ArgClass::class)->getName('fake'); //Will return Fake
```

## Validate data

```php
class ArgInterceptor {
    public function getValidData(array $data) {
        $validator = \Illuminate\Support\Facades\Validator::make($data, [
            'id' => 'required',
        ])->validate();
    }
};

class ArgClass implements \Larapackages\Interceptor\InterceptorInterface {
    public function getValidData(array $data) {
        return $data;
    }

    public static function interceptors(): array
    {
        return [
            ArgInterceptor::class
        ];
    }
};

$class = app()->make(ArgClass::class)->getValidData(['name' => 'fake']); //Will throw a validation exception
$class = app()->make(ArgClass::class)->getValidData(['id' => 1]); //Will return ['id' => 1]
```

## Return responses

```php
class ArgInterceptor {
    public function getName(string $name) {
        if ($name === 'test') {
            return 'Test Name';
        }
    }
};

class ArgClass implements \Larapackages\Interceptor\InterceptorInterface {
    public function getName(string $name) {
        return $name;
    }

    public static function interceptors(): array
    {
        return [
            ArgInterceptor::class
        ];
    }
};

$class = app()->make(ArgClass::class)->getName('test'); //Will return Test Name
$class = app()->make(ArgClass::class)->getName('second test'); //Will return second test
```

# Cache
In order to improve performance, this package have two commands to generate and clear cache.
Package will automatically use the cache file if exists, otherwise it scans the paths.

Generate cache:
~~~
php artisan interceptor:cache
~~~

Clear cache:
~~~
php artisan interceptor:clear
~~~

# Issues & Contributing
If you find an issue please report it or contribute by submitting a pull request. 