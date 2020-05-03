<?php

namespace Larapackages\Tests\Unit\Services\InterceptorService;

use Illuminate\Support\Facades\File;
use Illuminate\Support\LazyCollection;
use Larapackages\Interceptor\Services\InterceptorService;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Traits\ReflectionTrait;
use Larapackages\Tests\Unit\Services\InterceptorService\Interceptors\TestInterceptor;

/**
 * Class GetCacheInterceptorsFileExistsTest.
 */
class GetCacheInterceptorsFileExistsTest extends TestCase
{
    use ReflectionTrait;

    public function testGetCacheInterceptorsFileExists()
    {
        $cache_file = __DIR__.'/interceptors.php';
        config()->set('interceptor.cache_file', $cache_file);

        $file_content = <<<EOD
<?php

return [
	Larapackages\Tests\Unit\Services\InterceptorService\Interceptors\TestInterceptor::class,
];
EOD;
        File::put($cache_file, $file_content);

        $service = new InterceptorService();
        $interceptors = $service->getCacheInterceptors();

        $this->assertInstanceOf(LazyCollection::class, $interceptors);
        $this->assertCount(1, $interceptors);
        $this->assertContains(TestInterceptor::class, $interceptors);

        File::delete($cache_file);
    }
}
