<?php

namespace App\Providers;

use Illuminate\Hashing\HashServiceProvider;
use App\Helpers\SHAHasher as SHAHasher;

class ShaHashServiceProvider extends HashServiceProvider
{
    public function register()
    {
        $this->app->singleton('hash', function () {
            return new SHAHasher;
        });
    }
}
