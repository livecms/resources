<?php

namespace LiveCMS\Resources;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // 
    }

    public function register()
    {
        require __DIR__.'/../helper.php';
    }
}
