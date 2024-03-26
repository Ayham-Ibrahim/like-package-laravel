<?php

namespace Ayham\Like\Provider;
use Illuminate\Support\ServiceProvider;

class LikeServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/create_likes_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_likes_table.php'),
        ], 'migrations');

    }


}


