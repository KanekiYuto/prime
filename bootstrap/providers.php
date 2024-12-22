<?php

use Handyfit\Framework\CascadeServiceProvider;
use Handyfit\Framework\HandyFitServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\PreacherServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    HandyFitServiceProvider::class,
    CascadeServiceProvider::class,
];
