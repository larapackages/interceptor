<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | This value determines the "paths" that should be scanned searching classes
    | that implements InterceptorInterface
    |
    */

    'paths' => [app_path()],

    /*
    |--------------------------------------------------------------------------
    | Cache file
    |--------------------------------------------------------------------------
    |
    | This value determines the "file" that should be used for save cache
    | of scanned paths for better performance on large projects
    |
    */
    'cache_file' => app()->bootstrapPath('cache/interceptors.php'),

];
