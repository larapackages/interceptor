<?php

namespace Larapackages\Tests\Unit\Console\InterceptorCacheCommandTest;

use Illuminate\Support\Facades\File;
use Illuminate\Support\LazyCollection;
use Larapackages\Interceptor\Providers\InterceptorServiceProvider;
use Larapackages\Interceptor\Services\InterceptorService;
use Larapackages\Tests\TestCase;
use Larapackages\Tests\Unit\Console\InterceptorCacheCommandTest\Interceptors\InterceptorOne;
use Larapackages\Tests\Unit\Console\InterceptorCacheCommandTest\Interceptors\InterceptorTwo;

/**
 * Class HandleTest.
 */
class HandleTest extends TestCase
{
    public function testHandle()
    {
        $this->mock(InterceptorService::class, function ($mock) {
            $mock->shouldReceive('getInterceptors')->andReturn(LazyCollection::make(function () {
                foreach ([InterceptorOne::class, InterceptorTwo::class] as $class) {
                    yield $class;
                }
            }));
        });

        $file = __DIR__.'/interceptors.php';
        config()->set('interceptor.cache_file', $file);

        $this->artisan('interceptor:cache')
            ->expectsOutput('Interceptors cached successfully!');

        $expected_content = <<<EOD
<?php

return [
	Larapackages\Tests\Unit\Console\InterceptorCacheCommandTest\Interceptors\InterceptorOne::class,
	Larapackages\Tests\Unit\Console\InterceptorCacheCommandTest\Interceptors\InterceptorTwo::class,
];
EOD;
        $this->assertTrue(File::exists($file));
        $this->assertSame($expected_content, File::get($file));

        File::delete($file);
    }

    protected function getPackageProviders($app)
    {
        return [InterceptorServiceProvider::class];
    }
}
