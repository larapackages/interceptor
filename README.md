[![Build Status](https://circleci.com/gh/larapackages/interceptor.svg?style=shield)](https://circleci.com/gh/larapackages/interceptor)
[![StyleCI Status](https://github.styleci.io/repos/260661140/shield)](https://github.styleci.io/repos/260661140)
![StyleCI Status](https://img.shields.io/packagist/dt/larapackages/interceptor)

# Why do I need it?
### For intercept calls to classes and abstract part of the logic to smaller classes.

# Installation
Install with composer
~~~
composer require larapackages/interceptor
~~~

# Copy the package config to your local config with the publish command:
php artisan vendor:publish --provider="Larapackages\Interceptor\Providers\InterceptorServiceProvider"

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

##Modifying arguments

```php
class ArgInterceptor {
    public function getName($name) {
        $name = mb_strtoupper($name);
        
        return compact('name');
    }

    public static function interceptors(): array
    {
        return [
            // Classes namespaces that will intercept this class
        ];
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

##Validate data

```php
class ArgInterceptor {
    public function getValidData(array $data) {
        $validator = \Illuminate\Support\Facades\Validator::make($data, [
            'id' => 'required',
        ])->validate();
    }

    public static function interceptors(): array
    {
        return [
            // Classes namespaces that will intercept this class
        ];
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

##Return responses

```php
class ArgInterceptor {
    public function getName(string $name) {
        if ($name === 'test') {
            return 'Test Name';
        }
    }

    public static function interceptors(): array
    {
        return [
            // Classes namespaces that will intercept this class
        ];
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

# Issues & Contributing
If you find an issue please report it or contribute by submitting a pull request. 